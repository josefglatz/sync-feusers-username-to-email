<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Backend\Hook;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class DataHandlerSyncHook
 * @package JosefGlatz\SyncFeUsersUsernameToEmail\Backend\Hook
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class DataHandlerSyncHook implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    const SOURCE_COLUMN = 'username';
    const TARGET_COLUMN = 'email';
    const TABLE = 'fe_users';

    /**
     * Hook method for synchronizing columns before persisting a record in the database
     *
     * @param array $incomingFieldArray The array of fields and values that are going to be saved to the database.
     * @param string $table The table the data is going to be stored in
     * @param mixed $id The record's ID in the database, or a string if a new record is being created
     * @param DataHandler $dataHandler Reference to the data handler object
     */
    public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, DataHandler $dataHandler): void
    {
        // Operate only on correct table
        if ($table !== self::TABLE) {
            return;
        }

        // Do not operate when disabled via page TSconfig
        if (isset($incomingFieldArray['pid'])) {
            $pid = (int)$incomingFieldArray['pid'];
        } else {
            $pageRow = BackendUtility::getRecord($table, $id, 'pid');
            $pid = $pageRow['pid'];
        }

        $pageTSconfig = BackendUtility::getPagesTSconfig($pid);

        if (isset($pageTSconfig['tx_sync_feusers_username_to_email']['executeSyncViaDataHandlerHook'])
            && !(bool)$pageTSconfig['tx_sync_feusers_username_to_email']['executeSyncViaDataHandlerHook']
        ) {
            return;
        }

        // Synchronize columns
        if (isset($incomingFieldArray[self::SOURCE_COLUMN])) {
            $incomingFieldArray[self::TARGET_COLUMN] = $incomingFieldArray[self::SOURCE_COLUMN];
        }
    }

    /**
     * Hook method while creating a fe_users copy
     *
     * - update email field after the TYPO3 DataHandler persisted a new record with adopted username suffix
     *
     * This hook method extends "self::processDatamap_preProcessFieldArray" because it's not possible to sync the fields
     * in all DataHandler commands with processDatamap_preProcessFieldArray.
     *
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param DataHandler $dataHandler
     * @return void
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, DataHandler $dataHandler)
    {
        // Early return
        if ($status !== 'new' || $table !== 'fe_users') {
            return;
        }
        $pageTSconfig = BackendUtility::getPagesTSconfig((int)$fieldArray['pid']);
        // Do not operate when disabled via page TSconfig
        if (isset($pageTSconfig['tx_sync_feusers_username_to_email']['executeSyncViaDataHandlerHookOnCopyPaste'])
            && !(bool)$pageTSconfig['tx_sync_feusers_username_to_email']['executeSyncViaDataHandlerHookOnCopyPaste']
        ) {
            return;
        }

        // Check if email fields needs an update
        if ($fieldArray['email'] !== $fieldArray['username']) {
            // In this case the TYPO3 DataHandler has already persisted the record with modified username suffix
            // Let's fetch the uid of the persisted record via 'username' field
            $uid = $this->getUidByUsername($fieldArray['username'], (int)$fieldArray['pid']);
            // If found: use an own DataHandler instance to update the email field
            if ($uid) {
                // configure $data array for the TYPO3 DataHandler
                $data = [
                    self::TABLE => [
                        $uid => [
                            'email' => $fieldArray['username']
                        ]
                    ]
                ];
                // Instantiate DH
                /** @var DataHandler $dataHandler */
                $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
                $dataHandler->start($data, []);
                // Process the updates (A sys_history entry gets automatically created by using the DH)
                $dataHandler->process_datamap();
                // Log any errors produced by TYPO3 DataHandler
                if ($dataHandler->errorLog !== []) {
                    $this->logger->error('Error(s) while syncing fe_users.username to fe_users.email after pasting a fe_user copy');
                    foreach ($dataHandler->errorLog as $log) {
                        // handle each error in a log entry
                        $this->logger->error($log);
                    }
                }
            }
        }
    }

    /**
     * Returns the uid of the record by given username and pid (page uid)
     * @return false|mixed
     * @throws \Doctrine\DBAL\Exception
     */
    private function getUidByUsername(string $username, int $pid): mixed
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::TABLE);

        // do not use enabled fields here
        $queryBuilder->getRestrictions()->removeAll();

        // create query
        $queryBuilder
            ->select('uid')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq('username', $queryBuilder->createNamedParameter($username)),
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, Connection::PARAM_INT)),
            );

        // execute query
        $uid = $queryBuilder->executeQuery()->fetchOne();

        // return the uid of the affected database row
        if (is_int($uid)) {
            return $uid;
        }
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}

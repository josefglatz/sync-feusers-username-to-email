<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Service;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Class SyncColumnsService
 * @package JosefGlatz\SyncFeUsersUsernameToEmail\Service
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class SyncColumnsService
{
    public function __construct(protected readonly ConnectionPool $connectionPool)
    {
    }

    /**
     * @throws Exception
     */
    public function updateAllRecords(string $table, string $sourceColumn, string $targetColumn): int
    {
        $connection = $this->connectionPool->getConnectionForTable($table);

        // executing the query with a raw query as I was not able to convert the simple query to QueryBuilder
        // Pull requests are welcome! Thanks for your help!
        $sql = sprintf('
            UPDATE %s
            SET %s=%s
        ', $table, $targetColumn, $sourceColumn);

        $query = $connection->prepare($sql);
        $query->executeStatement();
        $query = $connection->executeQuery('
            UPDATE ' . $table . '
            SET ' . $targetColumn . '=' . $sourceColumn . '
        ');
        // Return the amount of affected records
        return $query->rowCount();
    }
}

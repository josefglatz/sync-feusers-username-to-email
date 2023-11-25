<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Backend\Form\FormDataProvider;

use JosefGlatz\SyncFeUsersUsernameToEmail\Helper\ArrayHelper;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * FormDataProvider for modifying processedTca on the fly based on the action
 *
 * - hides field email when creating a new frontend user record
 * - sets email field to readOnly if editing an existing frontend user record
 * - hides emailInformation NodeElement if disabled
 * - hides username placeholder if disabled
 *
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class FeUsersEmailFormDataProvider implements FormDataProviderInterface
{
    const TABLE_NAME = 'fe_users';
    const EMAIL_FIELD = 'email';
    const USERNAME_FIELD = 'username';
    const EMAIL_INFORMATION_NODE_ELEMENT = 'email_information';

    /**
     * @inheritDoc
     */
    public function addData(array $result): array
    {
        if ($this->providerExecutable($result)) {
            // hide the field 'email' at all when creating a new fe_users record as the field is filled when saving
            // via the DataHandler hook of this TYPO3 extension
            if ($result['command'] === 'new') {
                if (isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                    && is_array($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                    && isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.']['showEmailFieldForNewRecord'])
                    && !(bool)$result['pageTsConfig']['tx_sync_feusers_username_to_email.']['showEmailFieldForNewRecord']
                ) {
                    // @todo: process all configured types automatically on publish
                    // convert comma separated list to array
                    $fields = ArrayHelper::trimExplode(',', $result['processedTca']['types'][0]['showitem']);
                    // find position of field name to delete
                    $key = array_search(self::EMAIL_FIELD, $fields);
                    // delete it from the array
                    if ($key !== false) {
                        unset($fields[$key]);
                    }
                    // update showitem with removed field
                    $result['processedTca']['types'][0]['showitem'] = implode(',', $fields);

                    // remove the field from columns
                    unset($result['processedTca']['columns'][self::EMAIL_FIELD]);
                }

                // small improvement: hide lastlogin for a new record
                unset($result['processedTca']['columns']['lastlogin']);
            }

            if (isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && is_array($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.']['enableEmailInformation'])
                && !(bool)$result['pageTsConfig']['tx_sync_feusers_username_to_email.']['enableEmailInformation']
            ) {
                // Hide emailInformation NodeElement
                unset($result['processedTca']['columns'][self::EMAIL_INFORMATION_NODE_ELEMENT]);
            }

            if (isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && is_array($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.']['showPlaceholderForUsernameField'])
                && !(bool)$result['pageTsConfig']['tx_sync_feusers_username_to_email.']['showPlaceholderForUsernameField']
            ) {
                // Hide placeholder of 'username' column
                unset($result['processedTca']['columns'][self::USERNAME_FIELD]['config']['placeholder']);
            }

            if (isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && is_array($result['pageTsConfig']['tx_sync_feusers_username_to_email.'])
                && isset($result['pageTsConfig']['tx_sync_feusers_username_to_email.']['setEmailFieldToReadOnly'])
                && (bool)$result['pageTsConfig']['tx_sync_feusers_username_to_email.']['setEmailFieldToReadOnly']
            ) {
                // Set 'email' column to readonly
                $result['processedTca']['columns'][self::EMAIL_FIELD]['config']['readOnly'] = true;
            }
        }

        return $result;
    }

    private function providerExecutable(array $result): bool
    {
        if ($result['tableName'] === self::TABLE_NAME) {
            return true;
        }

        return false;
    }
}

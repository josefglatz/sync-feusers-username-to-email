<?php

use JosefGlatz\SyncFeUsersUsernameToEmail\Helper\ArrayHelper;
use JosefGlatz\SyncFeUsersUsernameToEmail\Helper\PositionHelper;

defined('TYPO3') or die();

/**
 * General modifications of the fe_users table via TCA/Overrides
 *
 * - Set column `username` to type "email"
 * - Add a meaningful placeholder to column `username`
 * - Add the custom FieldInformation node
 * - Place the custom FieldInformation node right before the column `username`
 * - Add meaningful description for field `email`
 *
 * @TODO: Modify all configured types and not just `0`.
 */
call_user_func(
    function ($extKey, $table) {
        $showitem = ArrayHelper::trimExplode(',', $GLOBALS['TCA'][$table]['types'][0]['showitem']);

        // Add emailInformation NodeElement to default recordType
        PositionHelper::addFieldToPosition($showitem, 'email_information', 'before:username');

        // Main TCA adoptions
        $tca = [
            'columns' => [
                'username' => [
                    // Configure the field username to an "email" field
                    'config' => [
                        'type' => 'email',
                        'placeholder' => 'LLL:EXT:sync_feusers_username_to_email/Resources/Private/Language/locallang_db.xlf:fe_users.field.username.placeholder'
                    ],
                ],
                // Add the emailInformation NodeElement for informational use
                'email_information' => [
                    'label' => '',
                    'config' => [
                        'type' => 'none',
                        'renderType' => 'emailInformation',
                    ],
                ],
                // Improve the email field description to inform an editor why this field is set to readOnly (via FormDataProvider)
                'email' => [
                    'description' => 'LLL:EXT:sync_feusers_username_to_email/Resources/Private/Language/locallang_db.xlf:fe_users.field.email.description',
                ],
            ],
            'types' => [
                0 => [
                    'showitem' => implode(',', $showitem),
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        // Also add the emailInformation NodeElement to every configured recordType
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            $table,
            'email_information',
            '',
            'before:username'
        );
    },
    'sync_feusers_username_to_email',
    'fe_users'
);

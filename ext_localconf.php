<?php
declare(strict_types=1);

use JosefGlatz\SyncFeUsersUsernameToEmail\Backend\Form\FormDataProvider\FeUsersEmailFormDataProvider;
use JosefGlatz\SyncFeUsersUsernameToEmail\Backend\Hook\DataHandlerSyncHook;
use JosefGlatz\SyncFeUsersUsernameToEmail\Backend\TCA\EmailInformationFormElement;
use TYPO3\CMS\Backend\Form\FormDataProvider\PageTsConfigMerged;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Register the DataHander hook for syncing value of username to email
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    DataHandlerSyncHook::class;

// Register FormDataProvider to set email field to readonly
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][FeUsersEmailFormDataProvider::class] = [
    'depends' => [
        PageTsConfigMerged::class
    ]
];

// Register FieldInformation node for the email column
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']['1700339021'] = [
    'nodeName' => 'emailInformation',
    'priority' => 10,
    'class' => EmailInformationFormElement::class
];

$versionInformation = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Typo3Version::class);
// Only include page.tsconfig if TYPO3 version is below 12 so that it is not imported twice.
if ($versionInformation->getMajorVersion() < 12) {
    ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:sync_feusers_username_to_email/Configuration/page.tsconfig"'
    );
}
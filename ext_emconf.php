<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Sync fe_users username to email',
    'description' => 'This TYPO3 extension takes care of syncing the fe_users.username to fe_users.email field when editing frontend users in the backend',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'JosefGlatz\\SyncFeUsersUsernameToEmail\\' => 'Classes/',
        ],
    ],
];

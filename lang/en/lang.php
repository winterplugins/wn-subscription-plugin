<?php

return [
    'plugin' => [
        'name' => 'Subscription',
        'description' => 'Send emails from WinterCMS',
    ],
    'models' => [
        'general' => [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'email' => [
            'label' => 'Email',
            'verified' => 'Verified',
            'verified_at' => 'Verified at',
            'label_plural' => 'Emails',
        ],
        'record' => [
            'label' => 'Record',
            'send' => 'Send',
            'subject' => 'Subject',
            'message' => 'Message',
            'label_plural' => 'Records',
        ]
    ],
];

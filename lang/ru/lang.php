<?php

return [
    'plugin' => [
        'name' => 'Подписка',
        'description' => 'Отправка писем из WinterCMS',
    ],
    'models' => [
        'general' => [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'email' => [
            'label' => 'Email',
            'subscribed' => 'Подтвержден',
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

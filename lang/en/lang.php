<?php

return [
    'plugin' => [
        'name' => 'Subscription',
        'description' => 'Send emails from WinterCMS',
    ],
    'components' => [
        'subscribeForm' => [
            'already_subscribed' => 'You are already subscribed',
            'need_waiting' => 'You must wait %s minutes before trying again'
        ],
        'confirmSubscription' => [
            'header' => 'Verification successful',
            'text' => 'Your email has been successfully added'
        ],
        'unsubscribe' => [
            'header' => 'Unsubscribe Successful',
            'text' => 'You have successfully unsubscribed from the mailing list'
        ]
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
            'send' => 'Send?',
            'subject' => 'Subject',
            'message' => 'Message',
            'label_plural' => 'Records',
            'emails_sent' => 'Emails sent',
            'total_emails' => 'Total emails',
            'start_sending' => 'Start sending',
            'finish_sending' => 'Finish sending'
        ]
    ],
];

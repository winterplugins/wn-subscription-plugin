<?php

return [
    'plugin' => [
        'name' => 'Подписка',
        'description' => 'Отправка писем из WinterCMS',
    ],
    'components' => [
        'subscribeForm' => [
            'already_subscribed' => 'Вы уже подписаны',
            'need_waiting' => 'Вы должны подождать %s минут, прежде чем пробовать снова'
        ],
        'confirmSubscription' => [
            'header' => 'Почта успешно подтверждена',
            'text' => 'Вы успешно подтвердили адрес электронной почты'
        ],
        'unsubscribe' => [
            'header' => 'Вы успешно отписались',
            'text' => 'Вы успешно отписались от рассылки'
        ]
    ],
    'models' => [
        'general' => [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Updated At',
        ],
        'email' => [
            'label' => 'Email',
            'verified' => 'Подтвержден',
            'verified_at' => 'Подтвержден в',
            'label_plural' => 'Emails',
        ],
        'record' => [
            'label' => 'Запись',
            'send' => 'Send',
            'subject' => 'Subject',
            'message' => 'Message',
            'label_plural' => 'Записи',
            'emails_sent' => 'Отправлено писем',
            'total_emails' => 'Всего',
            'start_sending' => 'Дата начала отправки',
            'finish_sending' => 'Дата окончания отправки'
        ]
    ],
];

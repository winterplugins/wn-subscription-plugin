<?php

declare(strict_types=1);

namespace Dimsog\Subscription;

use Dimsog\Subscription\Console\SendRecordsCommand;
use Backend\Facades\Backend;
use Dimsog\Subscription\Components\ConfirmSubscription;
use Dimsog\Subscription\Components\SubscribeForm;
use Dimsog\Subscription\Components\Unsubscribe;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function register(): void
    {
        $this->registerConsoleCommand('dimsog.subscription.sendRecordsCommand', SendRecordsCommand::class);
    }

    public function pluginDetails(): array
    {
        return [
            'name'        => 'dimsog.subscription::lang.plugin.name',
            'description' => 'dimsog.subscription::lang.plugin.description',
            'author'      => 'Dimsog',
            'icon'        => 'icon-file-text-o'
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'subscription' => [
                'label'       => 'dimsog.subscription::lang.plugin.name',
                'url'         => Backend::url('dimsog/subscription/records'),
                'icon'        => 'icon-at',
                'permissions' => ['*'],
                'order'       => 500,
                'sideMenu' => [
                    'records' => [
                        'label'       => 'dimsog.subscription::lang.plugin.name',
                        'icon'        => 'icon-file-text-o',
                        'url'         => Backend::url('dimsog/subscription/records'),
                    ],
                    'emails' => [
                        'label'       => 'dimsog.subscription::lang.models.email.label_plural',
                        'icon'        => 'icon-at',
                        'url'         => Backend::url('dimsog/subscription/emails'),
                    ]
                ]
            ]
        ];
    }

    public function registerSchedule($schedule): void
    {
        $schedule->command('subscription:send')->everyFiveMinutes();
    }

    public function registerComponents(): array
    {
        return [
            SubscribeForm::class => 'subscribeForm',
            ConfirmSubscription::class => 'confirmSubscription',
            Unsubscribe::class => 'unsubscribe'
        ];
    }

    public function registerMailTemplates(): array
    {
        return [
            'dimsog.subscription::mail.confirm_subscription',
            'dimsog.subscription::mail.message'
        ];
    }
}

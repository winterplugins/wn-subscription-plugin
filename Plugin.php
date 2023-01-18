<?php

declare(strict_types=1);

namespace Dimsog\Subscription;

use Backend\Facades\Backend;
use Dimsog\Subscription\Components\ConfirmSubscription;
use Dimsog\Subscription\Components\SubscribeForm;
use Dimsog\Subscription\Components\Unsubscribe;
use Dimsog\Subscription\Models\Email;
use Dimsog\Subscription\Models\Record;
use System\Classes\PluginBase;
use Winter\Storm\Support\Facades\DB;
use Winter\Storm\Support\Facades\Mail;

class Plugin extends PluginBase
{
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
        $schedule->call(static function (): void {
            $records = Record::where('send', 1)
                ->whereNull('start_sending_at')
                ->orderBy('id')
                ->get();
            $emails = Email::findSubscribedEmails();
            foreach ($records as $record) {
                $record->start_sending_at = DB::raw('NOW()');
                $record->total = count($emails);
                $record->save();
                foreach ($emails as $key => $email) {
                    Mail::sendTo($email, $record->text, [], static function ($message) use ($record) {
                        $message->subject($record->subject);
                    });
                    Record::where('id', $record->id)
                        ->update([
                            'current' => $key + 1
                        ]);
                }
            }
        })->everyFiveMinutes();
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
            'dimsog.subscription::mail.confirm_subscription'
        ];
    }
}

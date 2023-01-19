<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Console;

use Throwable;
use Cms\Classes\Page;
use Dimsog\Subscription\Models\Email;
use Dimsog\Subscription\Models\Record;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Winter\Storm\Console\Command;
use Winter\Storm\Support\Facades\Mail;

class SendRecordsCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'subscription:send';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'subscription:send';

    /**
     * @var string The console command description.
     */
    protected $description = '';


    public function handle()
    {
        $records = Record::where('send', 1)
            ->whereNull('start_sending_at')
            ->orderBy('id')
            ->get();
        $emails = Email::findSubscribedEmails();
        foreach ($records as $record) {
            $record->start_sending_at = Carbon::now();
            $record->total_emails = count($emails);
            $record->save();
            foreach ($emails as $key => $email) {
                try {
                    /** @var Email $email */
                    $result = Mail::sendTo($email->email, 'dimsog.subscription::mail.message', [
                        'text' => $record->text,
                        'unsubscribeUrl' => Page::url('unsubscribe', [
                            'code' => $email->unsubscribe_code
                        ])
                    ], static function ($message) use ($record) {
                        $message->subject($record->subject);
                    });
                    if ($result) {
                        Record::where('id', $record->id)
                            ->update([
                                'emails_sent' => $key + 1
                            ]);
                    }
                } catch (Throwable $e) {
                    Log::error('Dimsog.Subscription (send record to: ' . $email->email . '): ' . $e->getMessage());
                }
            }
            $record->finish_sending_at = Carbon::now();
            $record->save();
        }
    }
}

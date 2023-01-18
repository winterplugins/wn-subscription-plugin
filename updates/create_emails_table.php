<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateEmailsTable extends Migration
{
    public function up(): void
    {
        Schema::create('dimsog_subscription_emails', static function (Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('last_send_subscribe_code')->nullable();
            $table->string('email')->unique();
            $table->string('subscribe_code')->unique();
            $table->string('unsubscribe_code')->unique();
            $table->tinyInteger('subscribed')->default(0)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimsog_subscription_emails');
    }
}

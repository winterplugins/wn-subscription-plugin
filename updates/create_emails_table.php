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
            $table->timestamp('last_send_verification_code')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('email')->unique();
            $table->string('verify_code')->unique();
            $table->string('unsubscribe_code')->unique();
            $table->tinyInteger('verified')->default(0)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimsog_subscription_emails');
    }
}

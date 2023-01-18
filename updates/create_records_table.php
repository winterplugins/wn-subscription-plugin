<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateRecordsTable extends Migration
{
    public function up(): void
    {
        Schema::create('dimsog_subscription_records', static function (Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->tinyInteger('send')->default(0);
            $table->timestamp('start_sending_at')->nullable();
            $table->string('subject');
            $table->longText('text');
            $table->unsignedInteger('current')->default(0);
            $table->unsignedInteger('total')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimsog_subscription_records');
    }
}

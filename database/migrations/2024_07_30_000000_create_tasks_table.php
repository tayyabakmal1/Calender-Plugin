<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('calendar_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_type');
            $table->enum('repetition', ['one_time', 'monthly', 'every_6_months', 'yearly'])->default('one_time');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('task_name');
            $table->string('phone_number')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar_tasks');
    }
}; 
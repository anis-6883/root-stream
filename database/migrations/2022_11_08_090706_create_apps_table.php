<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();

            $table->string('app_unique_id', 191)->unique();
			$table->string('app_name', 191)->unique();
            $table->string('app_logo_type', 15);
            $table->text('app_logo_url')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('notification_type', 15);
            $table->string('onesignal_app_id', 191)->nullable();
            $table->string('onesignal_api_key', 191)->nullable();
			$table->string('firebase_server_key', 191)->nullable();
            $table->string('firebase_topics', 191)->nullable();
            $table->string('support_mail', 191)->nullable();
            $table->string('from_mail', 191)->nullable();
            $table->string('from_name', 191)->nullable();
            $table->string('smtp_host', 191)->nullable();
            $table->string('smtp_port', 191)->nullable();
            $table->string('smtp_username', 191)->nullable();
            $table->string('smtp_password', 191)->nullable();
            $table->string('smtp_encryption', 15)->nullable();
			$table->integer('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
};

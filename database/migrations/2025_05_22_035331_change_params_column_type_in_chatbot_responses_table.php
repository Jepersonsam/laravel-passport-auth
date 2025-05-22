<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeParamsColumnTypeInChatbotResponsesTable extends Migration
{
    public function up()
    {
        Schema::table('chatbot_responses', function (Blueprint $table) {
            $table->json('params')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('chatbot_responses', function (Blueprint $table) {
            $table->longText('params')->nullable()->change();
        });
    }
}

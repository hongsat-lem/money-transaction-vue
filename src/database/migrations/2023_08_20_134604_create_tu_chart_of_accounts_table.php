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
        Schema::create('tu_chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_ref');
            $table->timestamp('dt_cre')->nullable();
            $table->timestamp('dt_upd')->nullable();
            $table->integer('usr_cre')->nullable();
            $table->integer('usr_upd')->nullable();
            $table->integer('sort_index')->nullable();
            $table->boolean('is_default')->default(false);
            $table->smallInteger('sta_rec_id')->default(1);
            $table->string('sta_rec_code')->default('A');
            $table->foreignId('entity_id')->nullable()->constrained('tu_entities');
            $table->string('va_chat_account_title', 1000)->nullable();
            $table->string('va_chat_account_number', 1000)->nullable();
            $table->text('va_note')->nullable();
            $table->integer('enu_trans_type_id')->nullable();
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
        Schema::dropIfExists('tu_chart_of_accounts');
    }
};

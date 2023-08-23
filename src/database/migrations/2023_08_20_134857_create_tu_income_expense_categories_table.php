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
        Schema::create('tu_income_expense_categories', function (Blueprint $table) {
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
            $table->foreignId('chat_of_account_id')->nullable()->constrained('tu_chart_of_accounts');
            $table->smallInteger('enu_income_exp')->nullable();
            $table->boolean('is_income')->nullable();
            $table->string('va_category_name', 1000)->nullable();
            $table->text('va_category_description')->nullable();
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
        Schema::dropIfExists('tu_income_expense_categories');
    }
};

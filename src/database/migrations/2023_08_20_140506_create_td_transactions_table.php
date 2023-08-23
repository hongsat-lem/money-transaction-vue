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
        Schema::create('td_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_ref');
            $table->timestamp('dt_cre')->nullable();
            $table->timestamp('dt_upd')->nullable();
            $table->integer('usr_cre')->nullable();
            $table->integer('usr_upd')->nullable();
            $table->smallInteger('sta_rec_id')->default(1);
            $table->string('sta_rec_code')->default('A');
            $table->foreignId('entity_id')->nullable()->constrained('tu_entities');
            $table->foreignId('incom_exp_cat_id')->nullable()->constrained('tu_income_expense_categories');
            $table->foreignId('chat_account_id')->nullable()->constrained('tu_chart_of_accounts');
            $table->foreignId('account_id')->nullable()->constrained('tu_chart_of_accounts');
            $table->integer('invoice_id')->nullable();
            $table->integer('purchase_ordre_id')->nullable();
            $table->integer('purchase_return_id')->nullable();
            $table->integer('receive_user_id')->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained('tu_payment_method');
            $table->date('dt_transaction')->nullable();
            $table->string('va_txt_id')->nullable();
            $table->string('va_reference_id')->nullable();
            $table->smallInteger('enu_dr_cr')->nullable();
            $table->decimal('am_transaction')->nullable();
            $table->decimal('am_transaction_usd')->nullable();
            $table->text('va_payment_method_description')->nullable();
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
        Schema::dropIfExists('td_transactions');
    }
};

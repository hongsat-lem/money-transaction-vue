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
        Schema::create('tu_suppliers', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_ref');
            $table->timestamp('dt_cre')->nullable();
            $table->timestamp('dt_upd')->nullable();
            $table->integer('usr_cre')->nullable();
            $table->integer('usr_upd')->nullable();
            $table->smallInteger('sta_rec_id')->default(1);
            $table->string('sta_rec_code')->default('A');
            $table->foreignId('entity_id')->nullable()->constrained('tu_entities');
            $table->integer('country_id')->nullable();
            $table->string('va_supplier_name', 1000)->nullable();
            $table->string('va_company_name', 1000)->nullable();
            $table->string('va_vat_number')->nullable();
            $table->string('va_email')->nullable();
            $table->string('va_web')->nullable();
            $table->string('va_phone')->nullable();
            $table->string('va_telegram')->nullable();
            $table->string('va_wechat')->nullable();
            $table->text('va_address')->nullable();
            $table->string('va_country')->nullable();
            $table->string('va_city')->nullable();
            $table->string('va_state')->nullable();
            $table->string('va_postal_code')->nullable();
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
        Schema::dropIfExists('tu_suppliers');
    }
};

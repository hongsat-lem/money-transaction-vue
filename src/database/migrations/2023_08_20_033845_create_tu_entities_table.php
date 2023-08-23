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
        Schema::create('tu_entities', function (Blueprint $table) {
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
            $table->string('va_entity_name', 1000)->nullable();
            $table->string('va_entity_description', 1000)->nullable();
            $table->date('dt_registered')->nullable();
            $table->text('va_entity_address')->nullable();
            $table->text('va_entity_address_city')->nullable();
            $table->string('va_entity_phone_number')->nullable();
            $table->string('va_entity_email')->nullable();
            $table->string('va_entity_web')->nullable();
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
        Schema::dropIfExists('tu_entities');
    }
};

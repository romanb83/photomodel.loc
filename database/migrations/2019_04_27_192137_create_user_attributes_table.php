<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedDecimal('phone', 20, 0)->nullable();
            $table->string('eye_color', 30)->nullable();                   // Цвет глаз
            $table->string('hair_color', 30)->nullable();                  // Цвет волос
            $table->unsignedTinyInteger('height')->nullable();         // Рост
            $table->unsignedTinyInteger('weight')->nullable();         // Вес
            $table->unsignedTinyInteger('chest')->nullable();          // Обхват груди
            $table->unsignedTinyInteger('waist')->nullable();          // Обхват талии
            $table->unsignedTinyInteger('hip')->nullable();            // Обхват бёдер
            $table->unsignedTinyInteger('clothing_size')->nullable();  // Размер одежды
            $table->unsignedTinyInteger('foot_size')->nullable();      // Размер обуви
            $table->text('about')->nullable();                         // О себе
            $table->string('experience')->nullable();          // Опыт
            $table->boolean('is_tfp')->nullable()->index();                // Если True(TFP)
            $table->boolean('is_commerce')->nullable()->index();           // Если True(Commerce)
            $table->unsignedInteger('user_id');         // Ключ для связи с таблицей users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_attributes');
    }
}

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
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_type_id');
            $table->string('comment', 256);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('equipment', function (Blueprint $table) {
            $table->foreign('equipment_type_id')->references('id')->on('equipment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropForeign(['equipment_type_id']);
        });
        Schema::dropIfExists('equipment');
    }
};

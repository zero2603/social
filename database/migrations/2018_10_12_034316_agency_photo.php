<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgencyPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id');
            $table->string('source');
            $table->string('type')->default("normal"); // type: avatar, cover, normal
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
        Schema::dropIfExist('agency_photos');
    }
}

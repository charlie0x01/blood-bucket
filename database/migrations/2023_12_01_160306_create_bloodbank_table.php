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
        Schema::create('bloodbank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity');
            // city relation
            $table->unsignedBigInteger("city_id");
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");

            // blood group relation
            $table->unsignedBigInteger("blood_group_id");
            $table->foreign("blood_group_id")->references("id")->on("blood_groups")->onDelete("cascade");
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
        Schema::dropIfExists('bloodbank');
    }
};

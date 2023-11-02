<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("recipient_name");
            $table->string('contact_no', 13)->unique();
            $table->string('gender', 6);
            $table->integer('age')->unsigned();
            $table->string('address', 150);
            $table->string('hospital_name', 100)->nullable();
            $table->string('status', 15);

            // city relation
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");

            // blood group relation
            $table->unsignedBigInteger("blood_group_id")->nullable();
            $table->foreign("blood_group_id")->references("id")->on("blood_groups")->onDelete("cascade");
            
            // request sender
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            // donor
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->foreign('donor_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('blood_requests');
    }
}

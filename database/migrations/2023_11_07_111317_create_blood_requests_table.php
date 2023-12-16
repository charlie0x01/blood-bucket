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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            $table->unsignedBigInteger('blood_group_id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->float('age', 5, 2)->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_no', 13)->nullable();
            $table->text('address')->nullable();
            $table->string('hospital_name')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->string('request_state');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->boolean('emergency_flag');
            $table->date('need_on');
            $table->string('blood_report')->nullable();

            $table->foreign('blood_group_id')->references('id')->on('blood_groups');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('donor_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
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
};

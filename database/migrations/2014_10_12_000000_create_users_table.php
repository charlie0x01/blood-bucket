<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [User::TYPE_ADMIN, User::TYPE_DONOR, User::TYPE_RECIPIENT]);
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->float('age', 5, 2)->nullable();
            $table->string('contact_no', 13)->unique()->nullable();
            $table->string('gender', 6)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');


            // city relation
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");

            // blood group relation
            $table->unsignedBigInteger("blood_group_id")->nullable();
            $table->foreign("blood_group_id")->references("id")->on("blood_groups")->onDelete("cascade");

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

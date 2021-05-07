<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsmnomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asmnominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asm_id')->index(); // for faster search 
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('present_address',191)->nullable();
            $table->string('permanent_address',191)->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('nid')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('relation')->nullable();
            $table->string('relation_percentage')->nullable();

            $table->foreign('asm_id')->references('id')->on('asms')->onDelete('cascade');
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
        Schema::dropIfExists('asmnominees');
    }
}

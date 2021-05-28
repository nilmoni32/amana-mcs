<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bms', function (Blueprint $table) {
            $table->id();                     
            $table->string('bm_code')->unique(); 
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('present_address',191)->nullable();
            $table->string('permanent_address',191)->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('nid')->nullable();
            $table->string('email')->nullable();
            $table->string('mr_no')->nullable();
            $table->decimal('mr_amount', 20, 6)->nullable();            
            $table->dateTime('appointment_date')->nullable();            
            $table->enum('requirement_type', ['Promoted', 'Directly Appointed'])->default('Directly Appointed');
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('dist_name')->nullable();
            $table->string('dist_code')->nullable();
            $table->string('head_ofc_name')->nullable();
            $table->string('head_ofc_code')->nullable();
            
            //chain code
            $table->string('asm_code')->nullable();
            $table->string('asm_name')->nullable();
            $table->string('asm_code_change_notes')->nullable();// will be used while editing

            $table->string('rsm_code')->nullable();
            $table->string('rsm_name')->nullable();
            $table->string('rsm_code_change_notes')->nullable();// will be used while editing

            $table->string('agm_code')->nullable();
            $table->string('agm_name')->nullable();
            $table->string('agm_code_change_notes')->nullable();

            $table->string('dgm_code')->nullable();
            $table->string('dgm_name')->nullable();
            $table->string('dgm_code_change_notes')->nullable();// will be used while editing

            $table->string('gm_code')->nullable();
            $table->string('gm_name')->nullable();
            $table->string('gm_code_change_notes')->nullable();// will be used while editing
            
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
        Schema::dropIfExists('bms');
    }
}

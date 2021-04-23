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
            //$table->unsignedBigInteger('branch_id')->index(); // for faster search          
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
            $table->enum('requirement_type', ['Promoted', 'Directly Appointted'])->default('Directly Appointted');
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('dist_name')->nullable();
            $table->string('dist_code')->nullable();
            $table->string('head_ofc_name')->nullable();
            $table->string('head_ofc_code')->nullable();
            
            //Nominee Details.
            $table->string('nominee_name')->nullable();
            $table->string('nominee_father_name')->nullable();
            $table->string('nominee_mother_name')->nullable();
            $table->string('nominee_husband_name')->nullable();
            $table->string('nominee_present_address',191)->nullable();
            $table->string('nominee_permanent_address',191)->nullable();
            $table->dateTime('nominee_date_of_birth')->nullable();
            $table->string('nominee_photo')->nullable();
            $table->string('nominee_signature')->nullable();
            $table->string('nominee_nid')->nullable();
            $table->string('nominee_email')->nullable();
            $table->string('nominee_contact_no')->nullable();
            $table->string('relation1')->nullable();
            $table->string('relation_percentage1')->nullable();
            $table->string('relation2')->nullable();
            $table->string('relation_percentage2')->nullable();
            $table->string('relation3')->nullable();
            $table->string('relation_percentage3')->nullable();
            $table->string('relation4')->nullable();
            $table->string('relation_percentage4')->nullable();
            //chain code
            $table->string('asm_code')->unique()->nullable();
            $table->string('asm_name')->nullable();
            $table->string('asm_code_change_notes')->nullable();

            $table->string('rsm_code')->unique()->nullable();
            $table->string('rsm_name')->nullable();
            $table->string('rsm_code_change_notes')->nullable();

            $table->string('agm_code')->unique()->nullable();
            $table->string('agm_name')->nullable();
            $table->string('agm_code_change_notes')->nullable();

            $table->string('dgm_code')->unique()->nullable();
            $table->string('dgm_name')->nullable();
            $table->string('dgm_code_change_notes')->nullable();

            $table->string('gm_code')->unique()->nullable();
            $table->string('gm_name')->nullable();
            $table->string('gm_code_change_notes')->nullable();
            
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

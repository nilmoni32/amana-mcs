<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_code')->unique();
            $table->string('branch_name');
            $table->string('incharge_code')->nullable();
            $table->enum('designation', ['MO', 'BM', 'ASM','RSM','DGM','GM' ])->default('MO');
            $table->string('incharge_name')->nullable();
            $table->string('mobile_num')->nullable()->unique();
            $table->string('phone_num')->nullable()->unique();
            $table->string('address',191)->nullable();
            $table->string('dist_name')->nullable();
            $table->string('dist_code')->nullable();
            $table->string('head_ofc_name')->nullable();
            $table->string('head_ofc_code')->nullable();
            $table->string('list_chain_code')->nullable();
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
        Schema::dropIfExists('branches');
    }
}

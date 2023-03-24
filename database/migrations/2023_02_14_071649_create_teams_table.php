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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('m_name');
            $table->string('l_name')->nullable();
            $table->string('phone_no');
            $table->string('empId')->nullable();
            $table->string('email');
            $table->string('profession');
            $table->string('quote')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('services');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('teams');
    }
};

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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('study_field');
            $table->string('degree_type');
            $table->date('end_date')->nullable();
            $table->date('start_date')->nullable();
            $table->double('cgpa')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('applicant_id')->constrained('applicants','id');
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
        Schema::dropIfExists('education');
    }
};

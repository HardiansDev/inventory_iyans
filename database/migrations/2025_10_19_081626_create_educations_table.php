<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('education_level'); // misal: SD, SMP, SMA, S1, S2, D3
            $table->string('institution_name'); // nama sekolah / universitas
            $table->string('major')->nullable(); // jurusan
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->string('certificate_number')->nullable(); // No ijazah
            $table->string('gpa')->nullable(); // IPK (optional)
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
        Schema::dropIfExists('educations');
    }
}

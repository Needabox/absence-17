<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('gender'); // 0 for Male, 1 for Female
            $table->string('nis')->unique();  // Nomor Induk Siswa
            $table->string('nisn')->nullable();  // Nomor Induk Siswa Nasional
            $table->unsignedBigInteger('major_id');
            $table->integer('status')->default(1);  // Status (1 = Active, 0 = Inactive)
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

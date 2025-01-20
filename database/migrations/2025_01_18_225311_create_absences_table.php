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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->string('session'); 
            $table->string('justification')->nullable(); 
            $table->string('justification_file_path')->nullable(); // the new line
            $table->decimal('penalty', 8, 2)->default(0.2); 
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};

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
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('roll_no');
            $table->string('email');
            $table->enum('department', ['AE', 'AG', 'AD', 'AL', 'AU', 'BM', 'BT', 'CE', 'CB', 'CD', 'CS', 'CT', 'EE', 'EC', 'EI', 'FT', 'FD', 'IS', 'IT', 'ME', 'MC', 'TT']);
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('year', ['I', 'II', 'III', 'IV']);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('accommodation', ['Hosteller', 'Dayscholar'])->default('Hosteller');
            $table->enum('community', ['SC', 'ST', 'BC', 'BCM', 'MBC', 'DC']);
            $table->string('quota');
            $table->enum('seat_category', ['Management', 'Government Normal', 'Government Special'])->default('Management');
            $table->enum('course', ['B.E', 'B.Tech']);
            $table->enum('religion', ['Hindu', 'Muslim', 'Christian']);
            $table->enum('residency_status', ['India', 'Other'])->default('India');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']);
            $table->date('date_of_admission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};

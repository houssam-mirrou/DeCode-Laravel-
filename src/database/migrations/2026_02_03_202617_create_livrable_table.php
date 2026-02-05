<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livrable', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('comment')->nullable();
            $table->date('submission_date')->default(DB::raw('CURRENT_DATE'));
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('brief_id')->constrained('briefs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livrable');
    }
};

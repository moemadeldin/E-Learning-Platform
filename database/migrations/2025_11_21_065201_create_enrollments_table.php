<?php

declare(strict_types=1);

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
        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('course_id')
                ->nullable()
                ->index()
                ->constrained('courses')
                ->cascadeOnDelete();
            $table->timestamp('enrolled_at')->nullable();
            $table->float('progress')->default(0.0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['student_id', 'course_id']);
        });
    }
};

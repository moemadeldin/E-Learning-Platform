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
        Schema::create('teachers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->nullable()
                ->index()
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->string('national_id')->nullable();
            $table->boolean('is_approved')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->string('title')->nullable();
            $table->decimal('avg_rating', 3, 2)->default(0)->index();
            $table->unsignedBigInteger('reviews_count')->default(0)->index();
            $table->unsignedBigInteger('students_count')->default(0)->index();
            $table->unsignedInteger('courses_count')->default(0)->index();
            $table->timestamp('stats_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

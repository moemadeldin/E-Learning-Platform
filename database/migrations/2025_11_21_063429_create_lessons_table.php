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
        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')
                ->nullable()
                ->index()
                ->constrained('courses')
                ->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

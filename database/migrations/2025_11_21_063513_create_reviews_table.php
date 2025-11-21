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
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->index()
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->morphs('reviewable');
            $table->text('review')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

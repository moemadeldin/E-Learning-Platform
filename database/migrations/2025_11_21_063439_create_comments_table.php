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
        Schema::create('comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->index()
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('parent_comment_id')
                ->index()
                ->nullable()
                ->constrained('comments')
                ->cascadeOnDelete();
            $table->morphs('commentable');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

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
        Schema::create('lesson_attachments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lesson_id')
                ->index()
                ->nullable()
                ->constrained('lessons')
                ->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->stirng('size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

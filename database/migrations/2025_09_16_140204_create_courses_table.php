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
        Schema::create('courses', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable();
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
            $table->string('slug')->unique()->nullable()->index();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->longText('long_description')->nullable();
            $table->decimal('price', 8, 2)->nullable()->index();
            $table->boolean('is_free')->default(false)->index();
            $table->string('level')->nullable()->index();
            $table->char('language', 2)->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

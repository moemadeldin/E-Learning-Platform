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
        Schema::create('cart_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cart_id')
                ->index()
                ->nullable()
                ->constrained('carts')
                ->cascadeOnDelete();
            $table->foreignId('course_id')
                ->index()
                ->nullable()
                ->constrained('courses')
                ->cascadeOnDelete();
            $table->unique(['cart_id', 'course_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

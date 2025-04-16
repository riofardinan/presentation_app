<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() 
    {
        Schema::create('detail_tutorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutorial_id')->constrained('tutorials')->onDelete('cascade');
            $table->longText('content');
            $table->integer('order');
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tutorials');
    }
};

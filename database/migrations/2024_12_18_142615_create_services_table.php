<?php

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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->string('title');
            $table->text('description'); 
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->integer('category_id');
            $table->string('status')->default('active');
            $table->string('tr_token')->nullable(); 
            $table->foreign('tr_token')->references('token')->on('translations'); 
            $table->index(['tr_token']);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

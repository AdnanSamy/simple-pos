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
        Schema::create('stock_mutation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->enum('mutation_type', ['IN', 'OUT']);
            $table->timestamp('mutation_date')->useCurrent();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutation');
    }
};

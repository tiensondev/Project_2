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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');          
            $table->string('phone', 20);
            $table->string('province');     
            $table->string('district');    
            $table->string('ward');          
            $table->string('address_detail'); 
            $table->decimal('total', 12, 2);
            $table->enum('status', [
                '1',
                '2',
                '3',
                '0'
            ])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
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
        Schema::create('product_umkms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('umkm_id')->constrained('umkm_profiles')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_text');
            $table->text('full_text');
            $table->decimal('price', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_umkms');
    }
};

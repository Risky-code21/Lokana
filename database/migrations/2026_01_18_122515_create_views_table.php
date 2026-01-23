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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('viewable');
            $table->string('visitor_id', 64)->index();
            $table->string('ip_address', 45);
            $table->string('user_agent', 255);
            $table->unique(['visitor_id', 'viewable_id', 'viewable_type'], 'unique_visitor_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};

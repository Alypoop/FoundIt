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
        Schema::create('item_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->string('changed_from')->nullable(); // ✅ this was missing
            $table->string('changed_to')->nullable();   // ✅ this was missing
            $table->string('action');                   // e.g., "status update"
            $table->string('changed_by');               // e.g., user who changed it
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_histories');
    }
};

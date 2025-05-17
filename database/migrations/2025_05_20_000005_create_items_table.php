<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('photo_img')->nullable();
            $table->date('lost_date');

            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_type_id')->nullable()->constrained()->onDelete('set null');

            $table->longText('markings');
            $table->string('status')->default('Unclaimed');
            $table->string('bin')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();

            $table->string('location');
            $table->string('claimed_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
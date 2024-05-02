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
        Schema::create('pmpp_dtls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pmpp_hdr_id');
            $table->unsignedBigInteger('item_category');
            $table->unsignedBigInteger('item_name');
            $table->unsignedBigInteger('unit_of_measurement');
            $table->integer('item_quantity');
            $table->text('item_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmpp_dtls');
    }
};

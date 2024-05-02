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
        Schema::create('pmpp_hdr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prepared__by');
            $table->unsignedBigInteger('designation_by')->nullable();
            $table->unsignedBigInteger('fund_source');
            $table->float('budget')->nullable();
            $table->integer('year')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmpp_hdr');
    }
};

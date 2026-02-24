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
        Schema::create('colocations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('max_members');
            $table->enum('status', [0, 1]);
            $table->string('country');
            $table->string('city');
            $table->text('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colocations');
    }
};

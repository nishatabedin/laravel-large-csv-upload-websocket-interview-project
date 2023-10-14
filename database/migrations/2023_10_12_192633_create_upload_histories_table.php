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
        Schema::create('upload_histories', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); 
            $table->timestamp('uploaded_at'); 
            $table->string('upload_status'); 
            $table->string('file_hash')->nullable(); 
            $table->foreignId('user_id');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_histories');
    }
};

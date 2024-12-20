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
        Schema::create('crud_generator', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('desc');
            $table->string('table_name');
            $table->text('support'); // save array [title, desc, thumbnail, excerpt, slider]
            $table->tinyInteger('status')->default(1);
            $table->text('fields')->nullable();
            $table->tinyInteger('developer_mode')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_generates');
    }
};

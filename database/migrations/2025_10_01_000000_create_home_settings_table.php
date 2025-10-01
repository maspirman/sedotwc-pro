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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // hero, about, stats, cta
            $table->string('key'); // title, subtitle, image, etc
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, image, number
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['section', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};

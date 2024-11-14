<?php

use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->integer('round')->default(0);
            $table->integer('score')->default(0);
            $table->integer('attempts_left')->default(5);
            $table->integer('lives')->default(3);
            $table->integer('max_attempts')->default(5);
            $table->integer('max_lives')->default(3);
            $table->enum('status', ['in_progress', 'finished'])->default('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_sessions');
    }
};

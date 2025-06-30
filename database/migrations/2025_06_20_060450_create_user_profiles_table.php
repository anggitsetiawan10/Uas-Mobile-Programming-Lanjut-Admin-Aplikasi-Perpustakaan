<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->enum('gender', ['Laki-laki', 'Perempuan', 'Lainnya']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('phone');
            $table->text('address');
            $table->string('occupation')->nullable();
            $table->string('institution')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_profiles');
    }
};

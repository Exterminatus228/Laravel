<?php

declare(strict_types=1);

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
        Schema::create('user_roles', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
        });
        Schema::table('user_roles', static function (Blueprint $table) {
            $table->foreign('user_id', 'fk_user_roles_users')->references('id')->on('users');
            $table->foreign('role_id', 'fk_user_roles_roles')->references('id')->on('roles');
            $table->unique(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', static function (Blueprint $table) {
            $table->dropForeign('fk_user_roles_users');
            $table->dropForeign('fk_user_roles_roles');
        });
        Schema::dropIfExists('user_roles');
    }
};

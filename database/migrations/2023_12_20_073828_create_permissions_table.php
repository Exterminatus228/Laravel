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
        Schema::create('permissions', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedInteger('type');
            $table->timestamps();
        });
        Schema::table('permissions', static function (Blueprint $table) {
            $table->foreign('role_id', 'fk_permissions_roles')->references('id')->on('roles');
            $table->unique(['role_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', static function (Blueprint $table) {
            $table->dropForeign('fk_permissions_roles');
        });
        Schema::dropIfExists('permissions');
    }
};

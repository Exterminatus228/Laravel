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
        Schema::create('role_permissions', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
        });
        Schema::table('role_permissions', static function (Blueprint $table) {
            $table->foreign('role_id', 'fk_role_permissions_roles')->references('id')->on('roles');
            $table->foreign('permission_id', 'fk_role_permissions_permissions')->references('id')->on('permissions');
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_permissions', static function (Blueprint $table) {
            $table->dropForeign('fk_role_permissions_roles');
            $table->dropForeign('fk_role_permissions_permissions');
        });
        Schema::dropIfExists('role_permissions');
    }
};

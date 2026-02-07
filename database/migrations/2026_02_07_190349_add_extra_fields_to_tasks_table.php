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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->nullable()->after('id')->constrained('tasks')->nullOnDelete();
            $table->string('priority')->default('medium')->after('status');
            $table->string('type')->default('task')->after('priority');
            $table->string('status')->default('todo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn(['priority', 'type']);
            $table->enum('status', ['todo', 'doing', 'done'])->default('todo')->change();
        });
    }
};

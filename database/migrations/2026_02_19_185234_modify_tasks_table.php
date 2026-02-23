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
            //
            $table->dropForeign('tasks_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('comment');

            $table->foreignId('taskId')->references('task_id')->on('user_tasks')->onDelete('cascade');
            $table->longText('title');
            $table->longText('description')->nullable();
            $table->date('deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};

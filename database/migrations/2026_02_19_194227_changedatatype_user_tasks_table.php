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
        Schema::table('user_tasks', function (Blueprint $table) {
            //
             $table->dropForeign(['user_id']);
            $table->dropForeign(['task_id']);

             $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('task_id')->nullable()->change();

               $table->enum('status', ['Pending','Completed','DeadlinePassed'])->nullable()->change();
            $table->longText('feedback')->nullable()->change();
            $table->longText('taskans')->nullable()->change();
            $table->string('document')->nullable()->change();

       
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tasks', function (Blueprint $table) {
            //
        });
    }
};

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

        $table->enum('status',['Pending','Completed','DeadlinePassed'])->default('Pending');
        $table->longText('feedback')->nullable();
        $table->longText('taskans')->nullable();
        $table->string('document')->nullable();

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

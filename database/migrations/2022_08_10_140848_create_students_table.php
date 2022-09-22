<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary();
            $table->integer('parent_id')->nullable();
            $table->boolean('is_parent_confirmed')->default(false);
            $table->boolean('is_score_notified')->default(true);
            $table->boolean('is_resource_notified')->default(true);
            $table->boolean('is_extra_class_notified')->default(true);
            $table->string('parent_confirmation_code')->nullable();
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
        Schema::dropIfExists('students');
    }
};

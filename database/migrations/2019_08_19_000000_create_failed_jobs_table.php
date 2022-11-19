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
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2019_08_19_000000_create_failed_jobs_table.php
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
=======
            $table->string('name');
            $table->integer('grade');
            $table->string('group');
            $table->string('profesor');
            $table->date('begin_schedule');
            $table->date('end_schedule');
            $table->integer('album_id');
            $table->timestamps();
>>>>>>> c0fde7724cf24ca9bc5206b68aedf72fce527ebe:database/migrations/2022_11_17_091609_create_subjects_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
};

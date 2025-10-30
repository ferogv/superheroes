<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPictureAndSoftdeletesToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('superheroes', function (Blueprint $table) {
            if (!Schema::hasColumn('superheroes', 'picture')) {
                $table->string('picture')->nullable();
            }
            if (!Schema::hasColumn('superheroes', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        Schema::table('superheroes', function (Blueprint $table) {
            if (Schema::hasColumn('superheroes', 'picture')) {
                $table->dropColumn('picture');
            }
            if (Schema::hasColumn('superheroes', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}

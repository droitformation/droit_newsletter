<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoutienToNewsletterCampagnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->string('soutien')->after('header')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropColumn('soutien');
        });
    }
}

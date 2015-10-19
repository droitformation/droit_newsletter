<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRangToContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('contents', function($table)
        {
            $table->softDeletes();
            $table->dropColumn('slug');
            $table->integer('rang')->default(0);
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('contents', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropColumn('rang');
            $table->string('slug');
        });
	}

}

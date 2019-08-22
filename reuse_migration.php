<?php

// grouped field
function generalInfo($table) {
	$table->string('name');
	$table->string('age');
	$table->string('salary');
}

// on migration file
 public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            // calling basic migration column
			generalInfo( $table );

			// extra column
			$table->string('address');

            $table->timestamps();
        });
    }

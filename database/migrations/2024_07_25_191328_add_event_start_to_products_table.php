<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('event_name')->nullable();
            $table->string('event_host')->nullable();
            $table->timestamp('event_start_date')->nullable();
            $table->timestamp('event_end_date')->nullable();
            $table->timestamp('last_date_of_purchase')->nullable();
            $table->string('event_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
          $table->dropColumn('event_name');
          $table->dropColumn('event_host');
          $table->dropColumn('event_start_date');
          $table->dropColumn('event_end_date');
          $table->dropColumn('last_date_of_purchase');
          $table->dropColumn('event_location');
        });
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('country_code', 2)->nullable()->after('country');
            $table->string('floor')->nullable()->after('number_of_house');
            $table->string('door')->nullable()->after('floor');
            $table->float('latitude')->nullable()->after('door');
            $table->float('longitude')->nullable()->after('latitude');
            $table->string('parcel_number')->nullable()->after('longitude');
            $table->string('description')->nullable()->after('parcel_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->dropColumn('floor');
            $table->dropColumn('door');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('parcel_number');
            $table->dropColumn('description');
        });
    }
}

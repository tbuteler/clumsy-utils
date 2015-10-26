<?php

/*
 |--------------------------------------------------------------------------
 | Create PT Address Lookup View
 |--------------------------------------------------------------------------
 |
 | To create, run the following Artisan command (make sure you already have
 | the required tables):
 |
 | php artisan migrate --path=vendor/clumsy/utils/src/migrations/geo/pt
 |
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CreatePortugalAddressLookupView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__.'/address_lookup.sql'));

        App::shutdown(function () {

            DB::table('migrations')->where('migration', preg_replace('/\.php$/', '', basename(__FILE__)))->delete();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

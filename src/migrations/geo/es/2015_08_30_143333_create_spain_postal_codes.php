<?php

/*
 |--------------------------------------------------------------------------
 | Create Spain Postal Codes
 |--------------------------------------------------------------------------
 |
 | To create, run the following Artisan command:
 |
 | php artisan migrate --path=vendor/clumsy/utils/src/migrations/geo/es
 |
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CreateSpainPostalCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents('https://raw.githubusercontent.com/tbuteler/postal-sql/master/es/es.sql'));

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

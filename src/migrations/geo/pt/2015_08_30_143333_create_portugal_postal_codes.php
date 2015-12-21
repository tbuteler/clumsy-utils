<?php

/*
 |--------------------------------------------------------------------------
 | Create Portugal Postal Codes
 |--------------------------------------------------------------------------
 |
 | To create, run the following Artisan command:
 |
 | php artisan migrate --path=vendor/clumsy/utils/src/migrations/geo/pt
 |
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreatePortugalPostalCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        if (function_exists('bzdecompress')) {
            $tables = file_get_contents('https://raw.githubusercontent.com/tbuteler/postal-sql/master/pt/pt.sql.bz2');
            $tables = bzdecompress($tables);
        } else {
            $tables = file_get_contents('https://raw.githubusercontent.com/tbuteler/postal-sql/master/pt/pt.sql.gz');
            $tables = gzuncompress($tables);
        }

        try {

            DB::unprepared($tables);
            DB::unprepared(file_get_contents(__DIR__.'/address_lookup.sql'));

        } catch (\Exception $e) {

            $console = new ConsoleOutput();
            $console->writeln('<error>There was an error running the main tables query. Make sure your MySQL configuration accepts large (25MB+) packets. You can increase the limit by running `SET GLOBAL max_allowed_packet=524288000;`.</error>');
        }

        register_shutdown_function(function () {
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

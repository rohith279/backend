<?php namespace Rohit\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRohitMenu extends Migration
{
    public function up()
    {
        Schema::table('rohit_menu_', function($table)
        {
            $table->text('placeholder');
        });
    }
    
    public function down()
    {
        Schema::table('rohit_menu_', function($table)
        {
            $table->dropColumn('placeholder');
        });
    }
}

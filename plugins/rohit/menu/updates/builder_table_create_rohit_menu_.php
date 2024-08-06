<?php namespace Rohit\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRohitMenu extends Migration
{
    public function up()
    {
        Schema::create('rohit_menu_', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('title');
            $table->text('prompt');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rohit_menu_');
    }
}

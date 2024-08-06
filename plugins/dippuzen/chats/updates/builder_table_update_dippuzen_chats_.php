<?php namespace Dippuzen\Chats\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDippuzenChats extends Migration
{
    public function up()
    {
        Schema::table('dippuzen_chats_', function($table)
        {
            $table->text('uid');
        });
    }
    
    public function down()
    {
        Schema::table('dippuzen_chats_', function($table)
        {
            $table->dropColumn('uid');
        });
    }
}

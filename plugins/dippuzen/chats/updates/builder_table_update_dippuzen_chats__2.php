<?php namespace Dippuzen\Chats\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDippuzenChats2 extends Migration
{
    public function up()
    {
        Schema::table('dippuzen_chats_', function($table)
        {
            $table->text('conversation_id');
        });
    }
    
    public function down()
    {
        Schema::table('dippuzen_chats_', function($table)
        {
            $table->dropColumn('conversation_id');
        });
    }
}

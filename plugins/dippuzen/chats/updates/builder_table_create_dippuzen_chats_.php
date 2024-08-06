<?php namespace Dippuzen\Chats\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDippuzenChats extends Migration
{
    public function up()
    {
        Schema::create('dippuzen_chats_', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('title');
            $table->text('topic');
            $table->text('messages');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dippuzen_chats_');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclaratieTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'declaratie';

    /**
     * Run the migrations.
     * @table declaratie
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('declaratie_id');
            $table->integer('created_by_id');
            $table->integer('betaald_door_id');
            $table->decimal('bedrag', 10, 2);
            $table->text('omschrijving');
            $table->date('datum');

            $table->index(["created_by_id"], 'created_by_id');

            $table->index(["betaald_door_id"], 'betaald_door_id');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}

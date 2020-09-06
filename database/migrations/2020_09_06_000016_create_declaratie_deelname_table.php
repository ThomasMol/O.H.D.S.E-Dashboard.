<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclaratieDeelnameTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'declaratie_deelname';

    /**
     * Run the migrations.
     * @table declaratie_deelname
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('declaratie_id');
            $table->integer('lid_id');
            $table->decimal('bedrag', 10, 2);

            $table->index(["declaratie_id"], 'declaratie_id');

            $table->index(["lid_id"], 'lid_id');
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

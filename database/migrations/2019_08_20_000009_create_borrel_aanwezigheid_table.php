<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrelAanwezigheidTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'borrel_aanwezigheid';

    /**
     * Run the migrations.
     * @table borrel_aanwezigheid
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('borrel_id');
            $table->integer('lid_id');
            $table->tinyInteger('aanwezig')->nullable()->default(null);
            $table->decimal('naheffing', 10, 2)->nullable()->default(null);
            $table->tinyInteger('afgemeld')->nullable()->default(null);
            $table->integer('boete')->nullable()->default(null);
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

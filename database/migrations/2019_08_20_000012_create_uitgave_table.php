<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUitgaveTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'uitgave';

    /**
     * Run the migrations.
     * @table uitgave
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('uitgave_id');
            $table->date('datum');
            $table->decimal('budget', 10, 2)->nullable()->default(null);
            $table->decimal('uitgave', 10, 2);
            $table->decimal('naheffing', 10, 2)->nullable()->default(null);
            $table->text('omschrijving')->nullable()->default(null);
            $table->string('categorie');
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

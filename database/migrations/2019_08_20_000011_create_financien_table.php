<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancienTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'financien';

    /**
     * Run the migrations.
     * @table financien
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('lid_id');
            $table->decimal('overgemaakt', 16, 2);
            $table->decimal('verschuldigd', 16, 2);
            $table->decimal('schuld', 16, 2)->nullable()->default(null);
            $table->decimal('gespaard', 16, 2)->nullable()->default(null);

            $table->index(["lid_id"], 'lid_id');
            $table->timestamps();
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

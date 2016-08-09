<?php
namespace Serff\Cms\Modules\Core\PartialsModule\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Schema;

class CreatePartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content');
            $table->string('locale', 2);
            $table->unsignedInteger('author_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['slug', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('partials');
    }
}

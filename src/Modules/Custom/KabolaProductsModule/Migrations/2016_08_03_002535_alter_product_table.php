<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Schema;

class AlterProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('subtitle');
            $table->dropColumn('product_image');
            $table->dropColumn('intro_text');
            $table->dropColumn('product_content');
            
            $table->string('type');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('name');
            
            $table->string('title');
            $table->string('subtitle');
            $table->unsignedInteger('product_image');
            $table->text('intro_text');
            $table->text('product_content');
        });
    }
}

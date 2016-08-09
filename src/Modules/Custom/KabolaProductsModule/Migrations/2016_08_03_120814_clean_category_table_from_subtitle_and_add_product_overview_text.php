<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Schema;

class CleanCategoryTableFromSubtitleAndAddProductOverviewText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('subtitle');
            $table->text('overview_preview_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('overview_preview_text');
            $table->string('subtitle');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->index('group');
            $table->text('key');
            $table->jsonb('text');
            $table->jsonb('metadata')->nullable();
            $table->string('namespace')->default('*');
            $table->index('namespace');
            $table->softDeletes();
            $table->timestamps();
        });

        if (!Schema::hasColumn('users', 'lang')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('lang')->default('en');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('language_lines');

        if (Schema::hasColumn('users', 'lang')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('lang');
            });
        }
    }
}

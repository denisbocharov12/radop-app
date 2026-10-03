<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Одна запись на страницу и язык. Без этого индекса в таблице со временем
 * заводились вторые записи на ту же страницу, и какая из них попадёт в <head>,
 * решал порядок строк.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_metas', function (Blueprint $table) {
            $table->unique(['page_type', 'page_id', 'locale'], 'seo_metas_page_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::table('seo_metas', function (Blueprint $table) {
            $table->dropUnique('seo_metas_page_locale_unique');
        });
    }
};

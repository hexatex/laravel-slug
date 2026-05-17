<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlugsTable extends Migration
{
    public function up()
    {
        Schema::create('slugs', function (Blueprint $table) {
            $table->comment('See Hexatex\LaravelSlug\Slug\Contracts\Sluggable');

            $table->ulid('id')->index();
            $table->string('slug')->index();

            $table->ulidMorphs('sluggable');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slugs');
    }
}

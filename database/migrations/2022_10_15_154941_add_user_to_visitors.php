<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {

        Schema::table('visitors', function (Blueprint $table) {

        $table->foreignIdFor(User::class);

        $table->dropColumn('name');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()

    {

        Schema::table('visitors', function (Blueprint $table) {

        $table->string('name');

        $table->dropForeign('visitors_user_id_foreign');

        });

    }
};

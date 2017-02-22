<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;


use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE, function (Blueprint $table) {
            $table->increments(User::PRIMARY_KEY);
            $table->string(User::UUID, 60);
            $table->string(User::ApiToken, 100);
            $table->string(User::Name, 255);
            $table->string(User::Email)->unique();
            $table->string(User::Password);
            $table->smallInteger(User::RoleType);
            $table->string(User::AvatarUrl)->nullable();;
            $table->string(User::Phone)->nullable();;
            $table->text(User::Address)->nullable();;
            $table->smallInteger(User::IsEnabled)->default(1);
            $table->string(User::LastSeenIP)->nullable();;
            $table->timestamp(User::PasswordUpdatedAt)->nullable();
            $table->timestamp(User::LastActivityAt)->nullable();
            $table->timestamp(User::LastLoginAt)->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Creating index
            $table->index(User::IsEnabled);
            $table->index(User::Name);
            $table->index(User::Email);
        });

        // Creating default admin user
        DB::table(User::TABLE)->insert([
            User::UUID => \Ramsey\Uuid\Uuid::uuid4(),
            User::ApiToken => \Illuminate\Support\Str::random(90),
            User::Name => 'admin',
            User::Email => 'admin@admin.com',
            User::Password => Hash::make('admin'),
            User::RoleType => User::ROLE_ADMIN,
            User::CreatedAt => date("Y-m-d H:i:s")
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::TABLE);
    }
}

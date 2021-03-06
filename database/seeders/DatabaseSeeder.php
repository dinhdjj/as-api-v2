<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(LogSeeder::class);
        $this->call(RuleSeeder::class);
        $this->call(RechargedCardSeeder::class);
        $this->call(AccountTypeSeeder::class);
        $this->call(AccountInfoSeeder::class);
        $this->call(FileSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(ValidatorSeeder::class);
        $this->call(ValidationSeeder::class);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}

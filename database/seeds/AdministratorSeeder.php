<?php

use Illuminate\Database\Seeder;
use App\User;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->username = "adincomara";
        $admin->name = "Site Admin";
        $admin->email = "admin@larashop.test";
        $admin->roles = json_encode(["ADMIN"]);
        $admin->password = \Hash::make("milanisti88");
        $admin->avatar = "saat-ini-tidak-ada-file.png";
        $admin->phone ="081249295933";
        $admin->address = "Sarmili, Bintaro, Tangerang Selatan";

        $admin->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}

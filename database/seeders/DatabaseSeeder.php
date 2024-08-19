<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTables([
            'users',
        ]);
        // $this->call(UsersTableSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(StatSeeder::class);
        $this->call(CallSeeder::class);
        $this->call(PhoneSeeder::class);
        $this->call(JobSeeder::class);
    }

    protected function truncateTables(array $tables) {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //Aixo elimina la comprobacio de claus foranees per a borrar el contingut de la taula
        foreach ($tables as $table){
            DB::table($table)->truncate(); //Aixo elimina tots els registres de la taula per a poder tornar-los a crear
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //Torna a activar comprobacio de claus foranees
    }
}

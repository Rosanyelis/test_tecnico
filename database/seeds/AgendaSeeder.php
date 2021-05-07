<?php

use Illuminate\Database\Seeder;
Use App\Agenda;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Agenda::class, 20)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Features\Todo\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::factory()->count(10)->create();
    }
}

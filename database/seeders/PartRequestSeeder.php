<?php

namespace Database\Seeders;

use App\Models\PartRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PartRequest::factory()->count(40)->create();
    }
}

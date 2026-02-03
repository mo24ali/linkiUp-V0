<?php

namespace Database\Seeders;

use App\Models\Invitations;
use App\Models\Messagerie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invitations::factory()->count(10)->create();
    }
}

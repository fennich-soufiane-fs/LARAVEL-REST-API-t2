<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todolist;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::insert([
            [
                'title' => 'title 1',
                'desc' => 'desc 1',
                'is_done' => false,
            ],
            [
                'title' => 'title 2',
                'desc' => 'desc 2',
                'is_done' => true,
            ],
        ]);
    }
}

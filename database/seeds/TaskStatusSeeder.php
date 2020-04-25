<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = collect(['New', 'In Progress', 'In QA', 'Completed']);
        $statuses->each(function ($status) {
            DB::table('task_statuses')
                ->insert(['name' => $status, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        });
    }
}

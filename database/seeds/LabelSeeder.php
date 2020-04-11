<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LabelSeeder extends Seeder
{
    public function run()
    {
        $labels = collect([
            'bug',
            'documentation',
            'duplicate',
            'enhancement',
            'good first issue',
            'help wanted',
            'invalid',
            'question',
            'wontfix',
        ]);

        $labels->each(function ($label) {
            DB::table('labels')
                ->insert(['name' => $label, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        });
    }
}

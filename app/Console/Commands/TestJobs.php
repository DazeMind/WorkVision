<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProgramedRecordInsert;

class TestJobs extends Command
{
    protected $signature = 'job:RunProgramedRecordInsert';
    protected $description = 'Ejecuta el job ProgramedRecordInsert manualmente';

    public function handle()
    {
        ProgramedRecordInsert::dispatch();
        $this->info('Job ProgramedRecordInsert ejecutado correctamente.');
    }
}



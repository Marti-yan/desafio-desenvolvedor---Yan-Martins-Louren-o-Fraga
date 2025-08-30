<?php

namespace App\Jobs;

use App\Imports\ArquivoImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $arquivoId;
    public function __construct(string $filePath, int $arquivoId)
    {
        $this->filePath = $filePath;
        $this->arquivoId = $arquivoId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        //Log::info("1 -Path: {$this->filePath}");

         $filePath = $this->filePath ;

        //Log::info("Iniciando importação do arquivo: {$filePath}");
        Excel::queueImport(
            new ArquivoImport($this->arquivoId),
            $filePath,
            'local',
            \Maatwebsite\Excel\Excel::CSV,
            ['delimiter' => ';']
        );
    }
}

<?php

namespace App\Imports;


// Lib para Trabalhar com o arquivo Excel
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Models\LinhaArquivo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

HeadingRowFormatter::default('none'); // manter o formato  q vem do arquivo

class ArquivoImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    protected $arquivoId;

    public function __construct($arquivoId)
    {
        $this->arquivoId = $arquivoId; // associa o registro do arquivo
    }



    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);
        Log::info('Linha importada', $row); // verificação de teste, verifica se todas as linhas estão chegando corretamente;
        return new LinhaArquivo([
            'arquivo_id' => $this->arquivoId,
            'rptdt'      => $row['rptdt'] ?? null,
            'tckrsymb'   => $row['tckrsymb'] ?? null,
            'mktnm'      => $row['mktnm'] ?? null,
            'sctyctgynm' => $row['sctyctgynm'] ?? null,
            'isin'       => $row['isin'] ?? null,
            'crpnnm'     => $row['crpnnm'] ?? null
        ]);
    }

    public function chunkSize(): int
    {
        return 500; // carregar em lotes de 500 linhas por vez
    }
}

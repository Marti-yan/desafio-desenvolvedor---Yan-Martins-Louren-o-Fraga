<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ArquivoImport;
use App\Jobs\ImportCSVJob;
use App\Models\Arquivo;
use Maatwebsite\Excel\Facades\Excel;

class ArquivoController extends Controller
{

    public function import(Request $request)
    {

        $file = $request->file('file'); // Pega o arquivo enviado
        $nomeoriginal = $file->getClientOriginalName(); // Pega o nome original do arquivo
        $hash = md5_file($file->getRealPath()); // Gera um hash do arquivo para verificar duplicidade

        $request->validate([ // Valida o arquivo enviado
            'file' => 'required|file|mimes:xlsx,xls,csv,xlsm,CSV,XLSX,XLS,txt'
        ], [
            'file.required' => 'O arquivo é obrigatório.',
            'file.file' => 'O arquivo deve ser um arquivo válido.',
            'file.mimes' => 'O arquivo deve ser do tipo: xlsx, xls, csv, xlsm, CSV, XLSX, XLS.'
        ]);

        // deixei sem mostrar o .txt, pois não é um tipo de arquivo seguro, mas é necessário para o funcionamento do sistema.
        // não consegui implementar sem a extensão .txt, o mimetypes fica dando text/csv, e sem o text não leu, sei que não é uma feature segura porem é algo que voltarei a trabalhar.

        // Verificar se já tem algum outro arquivo com o mesmo hash
        if (Arquivo::where('file_hash', $hash)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Este arquivo já foi enviado.'
            ], 422);
        }

        $path = $file->storeAs('private/uploads', $nomeoriginal); // armazena o arquivo na pasta storage/app/uploads



        // faz o registro de identificação do arquivo na tabela Arquivo
        $registroArquivo = Arquivo::create([
            'file_hash' => $hash,
            'file_name' => $nomeoriginal
        ]);
        try {

            ImportCSVJob::dispatch($path, $registroArquivo->id); // despacha o job para importar o arquivo

            return response()->json([
                'message' => 'Sucesso, o arquivo foi enviado para a importação em 2° plano.',
                'arquivo_id' => $registroArquivo->id
            ]);
        } catch (\Exception $e) {
            // Retorna erro em JSON sem quebrar a aplicação
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

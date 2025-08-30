<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquivo;
use App\Models\LinhaArquivo;

class LinhaArquivoController extends Controller
{
    public function buscar(Request $request)
    {
        // Lista de campos permitidos para busca
        $camposPermitidos = [
            'RptDt',
            'rptdt',
            'TckrSymb',
            'tckrsymb',
            'MktNm',
            'mktnm',
            'SctyCtgyNm',
            'sctyctgynm',
            'ISIN',
            'isin',
            'CrpnNm',
            'crpnnm'
        ];

        // Pega apenas os campos enviados que estão na lista de permitidos
        $filtros = array_map('mb_strtolower', $request->only($camposPermitidos)); // pega apenas os campos permitidos pra buscar e passa tudo pra minusculo pra previnir erros

        //  Se não tiver filtro, retorna o ultimo arquivo, paginado
        if (empty($filtros)) {

            $arquivoId = $request->input('arquivo_id');

            // Se não for especificado o arquivo, pega o último importado
            if (!$arquivoId) {
                $arquivoId = \App\Models\Arquivo::latest('id')->value('id');
            }

            $linhas = \App\Models\LinhaArquivo::where('arquivo_id', $arquivoId)
                ->paginate(20);
            return response()->json($linhas);
        }

        // Se não for especificado o arquivo, pega o último importado
        $arquivoId = $request->input('arquivo_id');
        $usouArquivoId = !empty($arquivoId);
        if (!$arquivoId) {
            $arquivoId = \App\Models\Arquivo::latest('id')->value('id');
        }

        // Monta a query
        $query = \App\Models\LinhaArquivo::where('arquivo_id', $arquivoId);

        foreach ($filtros as $campo => $valor) { // percorre os filtros e monta a query
            $query->whereRaw("LOWER($campo) LIKE ?", ["%{$valor}%"]); // busca sem case sensitive
        }

        // Retorna todas as colunas da(s) linha(s) encontrada(s)
        $resultados = $query->get();

        if ($resultados->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nenhum dado encontrado para os filtros informados.'
            ]);
        }

        // Se a busca foi por campo, oculta `id` e `arquivo_id`
        if (!empty($filtros) && !$usouArquivoId) {
            $resultados->makeHidden(['id', 'arquivo_id']);
        }

        return response()->json($resultados);
    }
}

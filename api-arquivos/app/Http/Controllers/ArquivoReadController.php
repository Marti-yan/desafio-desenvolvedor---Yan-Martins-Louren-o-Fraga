<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Arquivo;

class ArquivoReadController extends Controller
{

    public function show($id)
    {
        try {
            return Arquivo::with('linhas')->find($id); // retorna o arquivo pelo ID
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nenhum arquivo encontrado.'
            ], 500);
        }
    }
    public function index(Request $request)
    {
        $arquivos = Arquivo::with('linhas')->get();
        return response()->json($arquivos);  // retorna todos os arquivos
    }

    public function pesquisa(Request $request)
    {
        
        try {
            $query = Arquivo::with('linhas'); //

            // Filtro por nome
            if ($request->has('nome')) {
                $query->where('file_name', 'like', '%' . $request->query('nome') . '%');
            }

            // Filtro por data (created_at)
            if ($request->has('data')) {
                $query->where('created_at', 'like', '%' . $request->query('data') . '%');
            }

            $arquivos = $query->get();

            if ($arquivos->isEmpty()) { 
                return response()->json([
                    'status' => 'vazio',
                    'message' => 'Nenhum arquivo encontrado'
                ], 404);
            }

            return response()->json($arquivos); // retorna os arquivos filtrados
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    
}

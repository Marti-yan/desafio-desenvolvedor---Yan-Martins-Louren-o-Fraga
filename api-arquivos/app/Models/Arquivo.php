<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $fillable = [
        'file_name',
        'file_hash'
    ];

    public function linhas()
    {
        return $this->hasMany(LinhaArquivo::class, 'arquivo_id');
    }

}

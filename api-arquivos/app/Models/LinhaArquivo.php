<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinhaArquivo extends Model
{
    use HasFactory;

    public $timestamps = false; // <- desativa created_at e updated_at
    protected $table = 'linhas_arquivo';
    protected $fillable = [
        'arquivo_id',
        'rptdt',
        'tckrsymb',
        'mktnm',
        'sctyctgynm',
        'isin',
        'crpnnm',
    ];

    public function arquivo()
    {
        return $this->belongsTo(Arquivo::class, 'arquivo_id');
    }
}
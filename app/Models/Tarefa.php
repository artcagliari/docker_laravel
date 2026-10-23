<?php

namespace App\Models;

use Database\Factories\TarefaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['titulo', 'descricao', 'concluida'])]
class Tarefa extends Model
{
    /** @use HasFactory<TarefaFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'concluida' => 'boolean',
        ];
    }
}

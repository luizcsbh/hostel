<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    /**
     *  Obtжm todas as relaушes definidas para o Modelo Daily
     * @retrun array
     */
    public function getRelations()
    {
        $relations = [];

        // Verifique se o modelo tem um relacionamento com hóspede
        if ($this->guests()->exists()) {
            $relations['guests'] = $this->guests;
        }

        // Adicione outras relaушes conforme necessрrio

        return $relations;
    }
}

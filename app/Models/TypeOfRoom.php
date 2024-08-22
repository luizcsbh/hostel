<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rules()
    {
        return [ 
            'name' => 'required|unique:type_of_rooms,name,'.$this->id.'|min:3|max:255',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'name.unique' => 'O nome do Tipo de Quarto já existe!',
            'name.min' => 'O nome do Tipo de Quarto deve ter no mínimo 3 caracteres!',
            'name.max' => 'O nome do Tipo de Quarto deve ter no maximo 255 caracteres!',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function dailies()
    {
        return $this->hasMany(Daily::class);
    }
    

     /**
     *  Obtжm todas as relaушes definidas para o Modelo Daily
     * @retrun array
     */
    public function getRelations()
    {
        $relations = [];
        $messages = [];

        // Verifique se o modelo tem um relacionamento com quartos
        if ($this->rooms()->exists()) {
            $relations['rooms'] = $this->rooms;
            $messages[] = 'Existem quartos associados a este tipo de quarto.';
        }

        // Verifique se o modelo tem um relacionamento com diárias
        if ($this->dailies()->exists()) {
            $relations['dailies'] = $this->dailies;
            $messages[] = 'Existem diárias associadas a este tipo de quarto.';
        }

        // Retorne as mensagens de relacionamento
        return $messages;
    }
}

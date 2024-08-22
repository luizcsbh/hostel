<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_room_id', 'quantity', 'number_of_beds', 'daily_id', 'description', 'available'];

    public function rules()
    {
        return [ 
            'type_of_room_id'   => 'exists:type_of_rooms,id',
            'quantity' => 'required|integer',
            'number_of_beds' => 'required|integer',
            'daily_id'   => 'exists:dailies,id',
            'description' => 'required|string|min:3|max:400',
            'available' => 'required|boolean',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'quantity.integer' => 'A :attribute deve ser um valor inteiro',
            'number_of_beds.integer' => 'A :attribute deve ser um valor inteiro',
            'description.min' => 'O nome do Tipo de Quarto deve ter no mínimo 3 caracteres!',
            'description.max' => 'O nome do Tipo de Quarto deve ter no maximo 400 caracteres!',
            'available.boolean' => 'O :attribute deve ser um valor booleano',
        ];
    }
    public function typeOfRoom()
    {
        return $this->belongsTo(TypeOfRoom::class);
    }

    public function dailies()
    {
        return $this->belongsTo(Daily::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    /**
     *  Obtжm todas as relaушes definidas para o Modelo Daily
     * @retrun array
     */
    public function getRelations()
    {
        $relations = [];

         // Verifique se o modelo tem um relacionamento com reservas
         if ($this->reserves()->exists()) {
            $relations['reserves'] = $this->reserves;
        }

        // Adicione outras relaушes conforme necessрrio

        return $relations;
    }
}

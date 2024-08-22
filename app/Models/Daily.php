<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_room_id', 'price'];

    public function rules($id = null)
    {
        return [
            'price' => 'required|numeric|min:0.01',
            'type_of_room_id' => [
                'required',
                'exists:type_of_rooms,id',
                function ($attribute, $value, $fail) use ($id) {
                    if ($id) {
                        // Se estamos atualizando, ignorar a verificação de unicidade para o próprio registro
                        $exists = self::where('type_of_room_id', $value)
                                    ->where('id', '<>', $id)
                                    ->exists();
                        if ($exists) {
                            $fail('O tipo de quarto selecionado já está em uso.');
                        }
                    } else {
                        // Verificar unicidade para novos registros
                        if (self::where('type_of_room_id', $value)->exists()) {
                            $fail('O tipo de quarto selecionado já está em uso.');
                        }
                    }
                }
            ],
        ];
    }


    public function feedback()
{
    return [
        'required' => 'O campo :attribute é obrigatório',
        'price.numeric' => 'O :attribute precisa ser numérico',
        'price.min' => 'O valor mínimo para o :attribute é R$0,01!',
        'type_of_room_id.unique' => 'O tipo de quarto já foi cadastrado, considere criar outro tipo de quarto',
        'type_of_room_id.exists' => 'O tipo de quarto selecionado não existe.',
    ];
}


    public function typeOfRoom()
    {
        return $this->belongsTo(TypeOfRoom::class);
    }

    // Uma Daily tem muitos Rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     *  Obtém todas as rela��es definidas para o Modelo Daily
     * @retrun array
     */
    public function getRelations()
    {
        $relations = [];

        // Verifique se o modelo tem um relacionamento com quartos
        if ($this->rooms()->exists()) {
            $relations['rooms'] = $this->rooms;
        }

        // Adicione outras rela��es conforme necess�rio

        return $relations;
    }
}

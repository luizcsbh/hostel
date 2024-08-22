<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'document_type_id', 'document_number', 'email', 'cellphone', 'birth'];

    protected $casts = [
        'birth' => 'date',
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    public function checkins()
    {
        return $this->hasMany(CheckIn::class);
    }

    public function checkouts()
    {
        return $this->hasMany(CheckOut::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     *  Obtжm todas as relaушes definidas para o Modelo Daily
     * @retrun array
     */
    public function getRelations()
    {
        $relations = [];

        // Verifique se o modelo tem um relacionamento com tipo documento
        if ($this->documentType()->exists()) {
            $relations['documentType'] = $this->documentType;
        }

        // Verifique se o modelo tem um relacionamento com reservas
        if ($this->reserves()->exists()) {
            $relations['reserves'] = $this->reserves;
        }

        // Verifique se o modelo tem um relacionamento com checkins
        if ($this->checkins()->exists()) {
            $relations['checkins'] = $this->checkins;
        }

        // Verifique se o modelo tem um relacionamento com checkouts
        if ($this->checkouts()->exists()) {
            $relations['checkouts'] = $this->checkouts;
        }

        // Verifique se o modelo tem um relacionamento com pagamentos
        if ($this->payments()->exists()) {
            $relations['payments'] = $this->payments;
        }

        // Adicione outras relaушes conforme necessрrio

        return $relations;
    }
}

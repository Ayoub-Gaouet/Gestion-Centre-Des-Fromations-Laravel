<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date_debut',
        'date_fin',
        'duree',
        'lieu',
        'prix',
        'is_terminated',
        'max_places',
    ];
    protected $dates = [
        'start_date',
        'end_date',
    ];
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

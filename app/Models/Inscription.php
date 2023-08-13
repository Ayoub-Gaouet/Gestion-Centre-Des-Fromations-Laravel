<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'client_id',
        'formation_id',
        'date_inscription',
        'montant',
        'etat',
        'eval',
        'dateEval',
        'commentaire',
    ];

    protected $dates = [
        'date_inscription',
        'dateEval',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

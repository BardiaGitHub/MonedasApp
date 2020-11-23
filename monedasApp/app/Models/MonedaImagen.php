<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonedaImagen extends Model
{
    
    use HasFactory;
    
    public $timestamps = false;
    
    protected $fillable = [
        'filepath',
        'moneda_id'
        ];
        
    public function moneda() {
        return $this->belongsTo('App\Models\Moneda');
    }
}

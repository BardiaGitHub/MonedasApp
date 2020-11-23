<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    
    use HasFactory;
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'simbolo',
        'pais',
        'cambioEuro',
        'fecha'
        ];
        
    public function moneda() {
        return $this->hasMany('App\Models\MonedaImagen');
    }
}

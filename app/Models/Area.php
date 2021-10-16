<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Area extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function personas(){
        return $this->belongsToMany(Persona::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //se crea la relación de tablas
    //relacion uno a uno: un post le pertenece a un usuario  y devuelve solo el nombre y sobrenombre
    public function user(){
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }


    //un post va a tener muchos comentarios
    //relacion uno a muchos
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}

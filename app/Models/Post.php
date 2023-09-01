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

    //un post va a tener muchos likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //revisar si un usuario ya dio like y evitar duplicados
    public function checkLike(User $user){
        //en este modelo Post, el método likes relacionado a la tabla Like contiene en la columna user_id el valor de $user_id
        return $this->likes->contains('user_id', $user->id);
    }
}

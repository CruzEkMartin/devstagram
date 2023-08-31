<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //creamos la relación con la tabla post, en caso de relacionar con un id diferente agregar ", 'nombrecolumna'" despues del modelo::class
    //relación uno a muchos: un usuario puede tener muchos posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //creamos la relacion con la tabla like, un usuario puede tener muchos likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //almacena los seguidores de un usuario, relacion muchos a muchos
    //el usuario va a tener el metodo followers() y va a insertar en la tabla 'followers' los campos user_id y follower_id
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //comprobar si un usuario sigue a otro
    //utiliza el metodo followers para verificar si la tabla 'followers' ya contiene un usuario con el id especificado
    public function siguiendo(User $user){
        return $this->followers->contains($user->id);
    }


    //almacena los usuarios que seguimos
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id' );
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public function store(Request $request, Post $post){
        
        //al estar relacionadas las tablas likes y comentarios no es necesario pasar el id del post, se obtiene autimático
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post){
        //en el modelo del usuario actual accedemos al metodo likes y si encuentra el post_id lo elimina
       $request->user()->likes()->where('post_id', $post->id)->delete();

       return back();
    }
}

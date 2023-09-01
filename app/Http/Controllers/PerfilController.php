<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        //modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        
        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil']
        ]);

        if ($request->imagen){
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            //guardar la imagen en el servidor con intervention image
            $imagenServidor = Image::make($imagen);
            //cortamos la imagen a un tamaño 1000px * 1000px desde el centro de la imagen
            $imagenServidor->fit(1000, 1000);
            //obtenemos la ruta donde se almacenará la imagen
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            //guardamos en el servidor
            $imagenServidor->save($imagenPath);
    
        }

        //guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        //almacena la imagen, si no tiene imagen deja la que tenía, si tampoco tenía pone null
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //

    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //guardar la imagen en el servidor con intervention image
        $imagenServidor = Image::make($imagen);
        //cortamos la imagen a un tamaño 1000px * 1000px desde el centro de la imagen
        $imagenServidor->fit(1000, 1000);
        //obtenemos la ruta donde se almacenará la imagen
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        //guardamos en el servidor
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}

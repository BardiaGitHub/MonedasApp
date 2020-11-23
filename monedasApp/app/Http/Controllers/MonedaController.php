<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moneda;
use App\Models\MonedaImagen;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Storage;
use DB;

class MonedaController extends Controller
{
    
    public function index()
    {
        $monedas = Moneda::all();
        $monedaImagenes = MonedaImagen::all();
        return view('moneda.index', compact('monedas', 'monedaImagenes'));
    }

    public function create()
    {
        return view('moneda.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        $moneda =  Moneda::create($request->all());
        if($request->hasfile('imagenes')) {
            foreach($request->imagenes as $file) {
                $name = uniqid().'.'.$file->extension();
                try {
                    $file->move(public_path('pictures'), $name);  
                    $imagen = MonedaImagen::create(
                    [
                        'filepath' => 'pictures/'.$name,
                        'moneda_id' => $moneda->id
                    ]);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return redirect()->route('moneda.index')->with('success','Moneda insertada correctamente.');
    }

    public function show($id)
    {
        $moneda = Moneda::find($id);
        $monedaImagenes = DB::table('moneda_imagens')->where('moneda_id', $id)->get();
        //$appURL = URL::to('/');
        return view('moneda.show', compact('moneda', 'monedaImagenes'/*, 'appURL'*/));
    }

    public function edit($id)
    {
        $moneda = Moneda::find($id);
        $monedaImagenes = DB::table('moneda_imagens')->where('moneda_id', $id)->get();
        //$appURL = URL::to('/');
        return view('moneda.edit', compact('moneda', 'monedaImagenes'/*, 'appURL'*/));
    }

    public function update(Request $request, $id)
    {
        Moneda::where('id', $id)->update($request->except(['_token', '_method', 'imagenes']));
        if($request->hasfile('imagenes')) {
            foreach($request->imagenes as $file) {
                $name = uniqid().'.'.$file->extension();
                try {
                    $file->move(public_path('pictures'), $name);  
                    $imagen = MonedaImagen::create(
                    [
                        'filepath' => 'pictures/'.$name,
                        'moneda_id' => $id
                    ]);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return redirect()->route('moneda.index')->with('success','Moneda editada correctamente.');
    }

    public function destroy($id)
    {
        $monedaImagenes = DB::table('moneda_imagens')->where('moneda_id', $id)->get();
        foreach($monedaImagenes as $imagen) {
            File::delete(public_path($imagen->filepath));
        }
        MonedaImagen::where('moneda_id', $id)->delete();
        Moneda::find($id)->delete();
        return redirect()->route('moneda.index')->with('success','Moneda borrada correctamente.');
    }
    
    public function deleteImage($id) {
        $imagen = MonedaImagen::find($id);
        File::delete(public_path($imagen->filepath));
        $imagen->delete();
        return back()->withInput()->with('image', 'Imagen borrada correctamente.');
    }
    
    public function search($value) {
        $searching = true;
        $monedas = Moneda::where('nombre', 'LIKE', '%'.$value.'%')->orwhere('pais', 'LIKE', '%'.$value.'%')->get();
        $monedaImagenes = MonedaImagen::all();
        return view('moneda.index', compact('monedas', 'monedaImagenes', 'searching'));
    }
}

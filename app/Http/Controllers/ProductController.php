<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate(5);

        return view("products.index", compact("products"));
    }

    public function create()
    {
        return view('products.create');
    }

    public function destroy($id)
    {
        // Busqueda del producto
        $product = Product::findOrFail($id);

        // Eliminacion el producto
        $product->delete();

        // Redireccion con un mensaje flash de sesion
        return redirect()->route('products.index')->with('status', 'Producto actualizado
        satisfactoriamente!');
    }

    public function store (Request $request)
        {
            //Validacion de los datos
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|string|max:20',
                'descripcion' => 'nullable|string|max:255',
                'precio_unitario' => 'required|numeric|min:0',
                'stock' => 'nullable|integer|min:1',
            ]);
            //Guardado de los datos
            Product::create($request->all());

            //Redireccion con un mensaje flash de sesion
            return redirect()->route('products.index')->with('status', 'Producto creado satisfactoriamente!');
        }
    public function edit($id)
        {
            $product = Product::findOrFail($id);
            return view('products.edit', ['product'=>$product]);
        }
    public function update(Request $request, $id)
        {
            //Busqueda del producto
            $product = Product::findOrFail($id);
            //Validacion de los datos 
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|string|max:20',
                'descripcion' => 'nullable|string|max:255',
                'precio_unitario' => 'required|numeric|min:0',
                'stock' => 'nullable|integer|min:1',
            ]);
            //Actualizacion del producto
            $product->update($request->all());

            //Redireccion con un msj flash de sesion
            return redirect()->route('products.index')->with('status', 'Producto actualizado satisfactoriamente!');
        }
}
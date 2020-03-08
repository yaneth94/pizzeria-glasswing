<?php

namespace App\Http\Controllers;

use App\DetallePizza;
use App\Http\Requests\PizzaRequest;
use App\Ingredient;
use App\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request){
       $pizzas = Pizza::orderby('id','DESC')
                        ->with('ingredients')
                        ->paginate(5);
        $ingredients = Ingredient::all();

        //dd($pizzas);
        return [
            'pagination' => [
                'total'         => $pizzas->total(),
                'current_page'  => $pizzas->currentPage(),
                'per_page'      => $pizzas->perPage(),
                'last_page'     => $pizzas->lastPage(),
                'from'          => $pizzas->firstItem(),
                'to'            => $pizzas->lastItem(),
            ],
            'pizzas' => $pizzas,
            'ingredients' => $ingredients
        ];
    }
    public function index()
    {
        return view('pizzas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pizzas.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PizzaRequest $request)
    {
        $pizza = new Pizza;
        $pizza->name_pizza = $request->name_pizza;
        $pizza->price = $request->price;
        $pizza->save();
        $pizza->ingredients()->sync($request->ingredients);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PizzaRequest $request, $id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->name_pizza = $request->name_pizza;
        $pizza->price = $request->price;
        $pizza->save();
        $pizza->ingredients()->sync($request->ingredients);
        return response()->json(['respuesta'=>'Pizza Modificada con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

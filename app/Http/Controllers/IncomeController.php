<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Income;
use Illuminate\Support\Facades\DB;
class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = DB::table('incomes')->sum('amount');
        $incomes = Income::latest()->paginate(5);
        return view('income.index',compact('incomes','total'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();
        return view('income.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'product_id' => 'required',
            'amount' => 'required',
            'account_details' => 'required'
        ]);


        Income::create($request->all());
        return redirect()->route('income.index')
            ->with('success',' created successfully.');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        return view('income.index',compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        $product = Product::all();
        return view('income.edit',compact('income','product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        request()->validate([
            'product_id' => 'required',
            'amount' => 'required',
            'account_details' => 'required'
        ]);
        $income->update($request->all());


        return redirect()->route('income.index')
            ->with('success','Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        $income->delete();
        return redirect()->route('income.index')
            ->with('success',' deleted successfully');


    }
}

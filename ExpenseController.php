<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Product;
use Illuminate\Support\Facades\DB;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(5);

        return view('expenses.index',compact('expenses'))
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
        return view('expenses.create',compact('product'));
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
            'name' => 'required',
            'price' => 'required',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')
            ->with('success','Expenses created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenses = Expense::find($id);
        return view('expenses.show',compact('expenses'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::all();
        $expenses = Expense::find($id);
        return view('expenses.edit',compact('expenses','product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'product_id' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);

        Expense::find($id)->update($request->all());

        return redirect()->route('expenses.index')
            ->with('success','Expense updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::find($id)->delete();

        return redirect()->route('expenses.index')
            ->with('success','Expenses deleted successfully');
    }

    public function report()
    {
        $total = DB::table('expenses')->sum('price');
        $currentMonth = date('m');
        $expenses = DB::table('expenses')
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->get();
        return view ('superadmin.expense.new',['expenses' =>$expenses,'total' => $total]);
    }
}

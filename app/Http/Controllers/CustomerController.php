<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Customer;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function create(){

        $zone = Zone::all();
        return view('superadmin.customer.createCustomer',compact('zone'));
        }

    public function save( Request $request){


        $customers = new Customer();
        $customers->customer_name = $request->customer_name;
        $customers->mobile_no = $request->mobile_no;
        $customers->email = $request->email;
        $customers->blood_group = $request->blood_group;
        $customers->national_id = $request->national_id;
        $customers->occupation = $request->occupation;
        $customers->address = $request->address;
        $customers->zone_id = $request->zone_id;
        $customers->month_amount = $request->month_amount;
        $customers->bill_amount = $request->bill_amount;
        $customers->connection_charge = $request->connection_charge;
        $customers->ip_address = $request->ip_address;
        $customers->connection_date = $request->connection_date;
        $customers->speed = $request->speed;
        $customers->status = $request->status;
        $customers->bill_status = 0;
        $customers->save();
        return redirect()->back()->with('message', 'Customer info saved ');
    }

    public function manageCustomer(Request $request){

        $customers =   DB::table('customers')
             ->join('zones', 'customers.zone_id', '=', 'zones.id')
             ->select('customers.*', 'zones.zone_name')
             ->orderBy('customers.id', 'DESC')
            ->paginate(8);

      //  dd($customers);

        $sun = Customer::sum('bill_amount');
        $zones = DB::table('zones')->get();


        return view('superadmin.customer.manageCustomer',['customers'=> $customers,'zones' => $zones,'sun' => $sun])
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function inactiveCustomer($id) {

        DB::table('customers')->where('id',$id)->update(['status' => 0]);
        return redirect('/customer/manage')->with('message', 'this guy is  unactive now');
    }
    public function activeCustomer($id) {

        DB::table('customers')->where('id',$id)->update(['status' => 1]);
        return redirect('/customer/manage')->with('message', 'this guy is  active now successfully');
    }

    public function editCustomer($id){
        $zone = Zone::all();
        $customerById = Customer::where('id',$id)->first();
        return view('superadmin.customer.editCustomer',compact('customerById','zone'));
    }
    public function updateCustomer(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $customer->customer_name = $request->customer_name;
        $customer->mobile_no = $request->mobile_no;
        $customer->email = $request->email;
        $customer->blood_group = $request->blood_group;
        $customer->national_id = $request->national_id;
        $customer->occupation = $request->occupation;
        $customer->address = $request->address;
        $customer->zone_id = $request->zone_id;
        $customer->month_amount = $request->month_amount;
        $customer->bill_amount = $request->bill_amount;
        $customer->connection_charge = $request->connection_charge;
        $customer->ip_address = $request->ip_address;
        $customer->connection_date = $request->connection_date;
        $customer->speed = $request->speed;
        $customer->status = $request->status;
        $customer->save();
        return redirect('customer/manage')->with('message','this info updated successfully');
    }

    public function deleteCustomer(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $customer->delete();

        return redirect('customer/manage')->with('success',' deleted successfully');
    }

    public function actives(){
        $customers = DB::table('customers')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->paginate(8);

        $zones = DB::table('zones')->get();
        $sun = Customer::sum('bill_amount');

        return view ('superadmin.customer.actives',['customers' =>$customers,'zones' => $zones,'sun'=>$sun])
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function inactive(){
        $customers = DB::table('customers')
            ->where('status', 0)
            ->orderBy('id', 'DESC')->paginate(8);

        $zones = DB::table('zones')->get();
        $sun = Customer::sum('bill_amount');

        return view ('superadmin.customer.inactives',['customers' =>$customers,'zones' => $zones,'sun'=>$sun])
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function current(){
        $currentMonth = date('m');
       $customers = DB::table('customers')
           ->whereRaw('MONTH(connection_date) = ?',[$currentMonth])
              ->orderBy('id', 'DESC')->paginate(7);

        $count = DB::table('customers')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('connection_date', Carbon::now()->month)
            ->count();


        $count1 = DB::table('customers')
            ->whereIn('status', [1])
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('connection_date', Carbon::now()->month)
            ->count();

        $count2 = DB::table('customers')
            ->whereIn('status', [0])
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('connection_date', Carbon::now()->month)
            ->count();


        return view ('superadmin.customer.current',['customers' =>$customers,'count' => $count,'count1' => $count1,'count2'=>$count2])
            ->with('i');


    }

    public function charge(){
        $currentMonth = date('m');
        $customers = DB::table('customers')
            ->whereRaw('MONTH(connection_date) = ?',[$currentMonth])
            ->paginate(8);

        return view ('superadmin.billing.connection',['customers' =>$customers])
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function mySearch() {

            $q = Input::get ( 'q' );
            $zone = Zone::where('zone_name','LIKE','%'.$q.'%')->get();
            if(count($zone) > 0)
                return view('superadmin.customer.manageCustomer')->withDetails($zone)->withQuery ( $q );
            else return view ('superadmin.customer.manageCustomer')->withMessage('No Details found. Try to search again !');
     }

}

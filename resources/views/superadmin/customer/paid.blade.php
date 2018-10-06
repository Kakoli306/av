@extends('superadmin.master')

@section('title')
    Paid Customer
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 "
             style=" background:#606060; margin-top:20px; margin-bottom: 15px; min-height:45px; padding:8px 0px 0px 15px; font-size:16px; font-family:Lucida Sans Unicode; color:#FFFFFF; font-weight:bold;">
            <div class="row">
                <div class="col-md-4">
                    <b>View All Paid Customer List</b>
                </div>

            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="container">
        <div class="row">
            <div class="summary">
                <h4 class="title">Paid Client</h4>
                         </div>


            <div class="col-sm-6">
                <div class="pull-right">

                </div>
            </div>

            <div class="col-md-3" style="">
                <form>
                    <div class="input-group">
                        <input type="search_text" name="search_text" id="search_text" class="form-control" placeholder="Search for...">
                    </div>
                </form>
            </div>


    <section class="card">
        <div class="container">

                <table class="table table-bordered table-striped mb-0 table-responsive" id="datatable-editable">

                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Customer ID</th>
                        <th>Address</th>
                        <th>Mobile Number</th>
                        <th>Speed</th>
                        <th>Bill</th>
                        <th>Email</th>
                        <th>Amount of Dues</th>
                        <th>IP</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->mobile_no }}</td>
                            <td>{{ $customer->speed}}</td>
                            <td>{{ $customer->bill_amount	}}</td>
                            <td>{{ $customer->email}}</td>
                            <td>0</td>
                            <td>{{ $customer->ip_address}}</td>
                        </tr>
                    </tbody>
                    @endforeach

                </table>
                {{ $customers->links() }}

            </div>
    </section>
        </div>
    </div>
    </div>

    <!-- end: page -->

@endsection

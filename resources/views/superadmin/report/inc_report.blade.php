@extends('superadmin.master')
@section('title')
    View Payment Information
@endsection
@section('content')

    <section class="card">
        <div class="container">

            <header class="card-header">
                <h2 class="card-title">View Customer Information</h2>
            </header>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                </div>
                <table class="table table-bordered table-striped mb-0 table-responsive" id="datatable-editable">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Bill Collection</th>
                        <th>Connection Charge</th>
                        <th>Others Income</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>



                          </table>
            </div>
        </div>
    </section>


@endsection
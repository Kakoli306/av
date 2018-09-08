@extends('superadmin.master')

@section('title')
    Monthly Report
@endsection

@section('content')
    {{ date('Y-m-d H:i:s') }}

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
                        <th>Expense</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($customers as $billing)
                        <tr>
                            <td>{{ $billing->id }}</td>
                            <td>{{ Carbon\Carbon::parse($billing->created_at)->format('d.m.Y') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="center">
                                <a href="{{ route('daily',['created_at'=>$billing->created_at]) }}" class="on-default edit-row">
                                    <i class="fas fa-pencil-alt"></i></a>
                            </td>


                        </tr>
                    </tbody>
                    @endforeach


                </table>
            </div>
        </div>
    </section>
    <!-- end: page -->

@endsection
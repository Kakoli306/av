@extends('superadmin.master')

@section('title')
    Account Statement
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
                        <th>User</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $ab=0; ?>
                    @foreach($merged as $key)
                        <tr>
                            <td></td>
                            <td>{{ $key->dates  }}</td>
                            <td>{{$users->username}}</td>
                            <td>{{ $key->sums  }}</td>
                            <td>{{ $key->expenses  }}</td>
                           <td></td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </section>
    <!-- end: page -->

@endsection

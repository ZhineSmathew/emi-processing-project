@extends('layouts.app')

@section('content')
    <a href="{{ route('loan.calculate') }}" class="btn btn-primary px-4">Calculate Emi</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Loan Details   ') }}</div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Client Id</th>
                                    <th scope="col">Number of Payments</th>
                                    <th scope="col">First payment date</th>
                                    <th scope="col">Last payment date</th>
                                    <th scope="col">Loan amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loanDetails as $loanDetail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $loanDetail->clientid }}</td>
                                        <td>{{ $loanDetail->num_of_payment }}</td>
                                        <td>{{ $loanDetail->first_payment_date }}</td>
                                        <td>{{ $loanDetail->last_payment_date }}</td>
                                        <td>{{ $loanDetail->loan_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

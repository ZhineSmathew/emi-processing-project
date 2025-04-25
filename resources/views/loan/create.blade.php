@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Loan EMI Calculator</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('processData') }}">
            @csrf

            <div class="mb-3">
                <label for="clientid" class="form-label">Client ID</label>
                <input type="number" name="clientid" id="clientid" value="{{ old('clientid') }}" class="form-control" placeholder="Enter Client ID">
                @error('clientid')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="loan_amount" class="form-label">Loan Amount</label>
                <input type="number" name="loan_amount" id="loan_amount" value="{{ old('loan_amount') }}" class="form-control"
                    placeholder="Enter Loan Amount" step="0.01">
                @error('loan_amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="num_of_payment" class="form-label">Number of Payments</label>
                <input type="number" name="num_of_payment" id="num_of_payment" value="{{ old('num_of_payment') }}" class="form-control"
                    placeholder="Enter Number of EMIs">
                @error('num_of_payment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="first_payment_date" class="form-label">First Payment Date</label>
                <input type="date" name="first_payment_date" id="first_payment_date"  value="{{ old('first_payment_date') }}" class="form-control">
                @error('first_payment_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="last_payment_date" class="form-label">Last Payment Date</label>
                <input type="date" name="last_payment_date" id="last_payment_date" value="{{ old('last_payment_date') }}" class="form-control">
                @error('last_payment_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Process Data</button>
        </form>
    </div>
@endsection

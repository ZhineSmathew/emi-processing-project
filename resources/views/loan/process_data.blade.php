@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>EMI Details</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($emiDetails->isEmpty())
            <p>No EMI records found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($columns as $column)
                                <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emiDetails as $row)
                            <tr>
                                @foreach ($columns as $column)
                                    <td>{{ $row->$column }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <a class="btn btn-info" href="{{ route('dashboard') }}"> Back</a>
@endsection

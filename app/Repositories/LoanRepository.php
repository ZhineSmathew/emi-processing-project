<?php

namespace App\Repositories;

use App\Models\Loandetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoanRepository
{
    protected $loandetail;

    public function __construct(Loandetail $loandetail)
    {
        $this->loandetail = $loandetail;
    }

    public function getAll()
    {
        return $this->loandetail->all();
    }

    public function create(array $data)
    {
        return Loandetail::create($data);
    }

    public function getMinAndMaxDates()
    {
        $loans = Loandetail::all();

        if ($loans->isEmpty()) {
            return ['min' => null, 'max' => null];
        }

        $minDate = $loans->min('first_payment_date');
        $maxDate = $loans->map(function ($loan) {
            return Carbon::parse($loan->first_payment_date)->addMonths($loan->num_of_payment - 1);
        })->max();

        return [
            'min' => $minDate,
            'max' => $maxDate,
        ];
    }

    public function getEmiDetails()
    {
        $data = DB::table('emi_details')->get();
        $columns = Schema::getColumnListing('emi_details');

        return [
            'data' => $data,
            'columns' => $columns,
        ];
    }
}

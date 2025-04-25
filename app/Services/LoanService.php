<?php

namespace App\Services;

use App\Repositories\LoanRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoanService
{
    protected $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function getLoanDetails()
    {
        return $this->loanRepository->getAll();
    }

    public function getMinAndMaxDates()
    {
        return $this->loanRepository->getMinAndMaxDates();
    }

    public function processData()
    {
        try {
            // fetch min & max dates
            $dates = $this->getMinAndMaxDates();
            $minDate = $dates['min'];
            $maxDate = $dates['max'];

            if (!$minDate || !$maxDate) {
                Log::warning('No data in loan_details table.');

                return false;
            }

            $start = Carbon::parse($minDate)->startOfMonth();
            $end = Carbon::parse($maxDate)->startOfMonth();

            $months = [];
            foreach (CarbonPeriod::create($start, '1 month', $end) as $date) {
                $months[] = $date->format('Y_M');
            }

            // Drop and recreate emi_details
            DB::statement('DROP TABLE IF EXISTS emi_details');

            $columns = [
                '`id` INT AUTO_INCREMENT PRIMARY KEY',
                '`clientid` INT',
            ];

            foreach ($months as $month) {
                $columns[] = "`$month` DECIMAL(10,2) DEFAULT 0.00";
            }

            $createTableSQL = 'CREATE TABLE emi_details ('.implode(', ', $columns).')';
            DB::statement($createTableSQL);

            $loans = $this->loanRepository->getAll();

            foreach ($loans as $loan) {
                $monthlyEmi = round($loan->loan_amount / $loan->num_of_payment, 2);
                $remaining = $loan->loan_amount;
                $firstPayment = Carbon::parse($loan->first_payment_date)->startOfMonth();

                $emiRow = array_fill_keys($months, 0.00);

                for ($i = 0; $i < $loan->num_of_payment; ++$i) {
                    $monthKey = $firstPayment->copy()->addMonths($i)->format('Y_M');

                    if ($i === $loan->num_of_payment - 1) {
                        $emi = round($remaining, 2);
                    } else {
                        $emi = $monthlyEmi;
                        $remaining -= $emi;
                    }

                    $emiRow[$monthKey] = $emi;
                }

                // Build insert data
                $insertData = ['clientid' => $loan->clientid] + $emiRow;

                // Insert into emi_details
                DB::table('emi_details')->insert($insertData);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('EMI processing failed: '.$e->getMessage());

            return false;
        }
    }

    public function getEmiDetails(): array
    {
        return $this->loanRepository->getEmiDetails();
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\LoanRepository;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;
    protected $loanRepository;

    public function __construct(LoanService $loanService, LoanRepository $loanRepository)
    {
        $this->loanService = $loanService;
        $this->loanRepository = $loanRepository;
    }

    public function index()
    {
        $loanDetails = $this->loanService->getLoanDetails();

        return view('/dashboard', compact('loanDetails'));
    }

    public function processData(Request $request)
    {
        $loanData = $request->validate([
            'clientid' => 'required|integer',
            'loan_amount' => 'required|numeric',
            'num_of_payment' => 'required|integer|min:1',
            'first_payment_date' => 'required|date',
            'last_payment_date' => 'required|date|after_or_equal:first_payment_date',
        ]);

        if ($loanData) {
            $loanDetail = $this->loanRepository->create($loanData);
        }

        $result = $this->loanService->processData();

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to generate EMI table.');
        }

        $emiData = $this->loanService->getEmiDetails();
        $emiDetails = $emiData['data'];
        $columns = $emiData['columns'];

        return view('loan.process_data', compact('emiDetails', 'columns'))
            ->with('success', 'EMI processing completed successfully.');
    }
}

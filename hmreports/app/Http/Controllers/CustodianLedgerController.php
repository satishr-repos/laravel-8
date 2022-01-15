<?php

namespace App\Http\Controllers\Tools;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustodianLedgerController extends Controller
{
    private $mismatch = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function verify_ledger($date, $lCredit, $lDebit, $cCredit, $cDebit, $otherCredit, $otherDebit)
    {
        $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
        $dateStr = $dateObj->format('d-m-y');
        // echo "$dateStr ledger credit: $lCredit customer debit: $cDebit".'<br>';
        // echo "$dateStr ledger debit: $lDebit customer credit: $cCredit".'<br>';
        if(round($lCredit,2) != round($cDebit,2))
        {
            // echo "<p style='color:red;'>$dateStr bank credit: $lCredit customer debit: $cDebit</p>";
            array_push($this->mismatch, 
                ['date' => $dateStr, 
                    'bank' => [ 'credit' => $lCredit, 'debit' => ''],
                    'customer' => [ 'credit' => '', 'debit' =>$cDebit ],
                    'other' => ['credit' => $otherCredit, 'debit' => $otherDebit ] ]);
        }

        if(round($lDebit,2) != round($cCredit,2))
        {
            // echo "<p style='color:blue;'> $dateStr bank debit: $lDebit customer credit: $cCredit</p>";
            array_push($this->mismatch, 
                ['date' => $dateStr, 
                    'bank' => [ 'credit' => '', 'debit' => $lDebit],
                    'customer' => [ 'credit' => $cCredit, 'debit' => ''],
                    'other' => ['credit' => $otherCredit, 'debit' => $otherDebit ] ]);
        }

    }

    public function index()
    {
        $inputFileName = Storage::path('private/CUSTODIAN_LEDGER.xlsx');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();

        $maxRows = $worksheet->getHighestRow();
        $maxCols = $worksheet->getHighestColumn();

        $startDate = 0;
        $ledgerCredit = 0;
        $ledgerDebit = 0;
        $customerCredit = 0;
        $customerDebit = 0;
        $otherCredit = 0;
        $otherDebit = 0;
        $startRow = 1;
        for($row=1; $row < $maxRows; $row++)
        {
            $cell = 'A'.$row;
            $value = $worksheet->getCell($cell)->getValue();

            if(gettype($value) !== 'integer')
            {
                continue;
            }

            $date = $value;
            if($date !== $startDate)
            {
                $this->verify_ledger($startDate, $ledgerCredit, $ledgerDebit, $customerCredit, $customerDebit, $otherCredit, $otherDebit);
                $startDate = $date;
                $ledgerCredit = 0;
                $ledgerDebit = 0;
                $customerCredit = 0;
                $customerDebit = 0;
                $otherDebit = 0;
                $otherCredit = 0;
                $startRow = $row;
            }

            $details = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $debit = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $credit = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

            // if(str_starts_with($details, 'INDUS IND BANK'))
            if(str_contains($details, 'INDIA STORY') || 
                str_contains($details, 'SYNERGY') || 
                str_contains($details, 'PROSPECT'))
            {
                $ledgerCredit += $credit;
                $ledgerDebit += $debit;
            }
            elseif(str_starts_with($details, 'PMS CONTROL') || str_starts_with($details, 'PMS MF CONTROL'))
            {
                $customerCredit += $credit;
                $customerDebit += $debit;
            }
            else
            {
                $otherCredit += $credit;
                $otherDebit += $debit;
            }

        }
    
        return View('tools.custodian', [ 'mismatches' => $this->mismatch]);
    }

}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CustodianLedgerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function verify_ledger($date, $lCredit, $lDebit, $cCredit, $cDebit)
    {
        $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
        $dateStr = $dateObj->format('d-m-yy');
        // echo "$dateStr ledger credit: $lCredit customer debit: $cDebit".'<br>';
        // echo "$dateStr ledger debit: $lDebit customer credit: $cCredit".'<br>';
        if(round($lCredit,2) != round($cDebit,2))
        {
            echo "$dateStr ledger credit: $lCredit customer debit: $cDebit".'<br>';
        }

        if(round($lDebit,2) != round($cCredit,2))
        {
            echo "$dateStr ledger debit: $lDebit customer credit: $cCredit".'<br>';
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
                $this->verify_ledger($startDate, $ledgerCredit, $ledgerDebit, $customerCredit, $customerDebit);
                $startDate = $date;
                $ledgerCredit = 0;
                $ledgerDebit = 0;
                $customerCredit = 0;
                $customerDebit = 0;
                $startRow = $row;
            }

            $details = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $debit = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $credit = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

            if(str_starts_with($details, 'INDUS IND BANK'))
            {
                $ledgerCredit += $credit;
                $ledgerDebit += $debit;
            }

            if(str_starts_with($details, 'PMS CONTROL') || str_starts_with($details, 'PMS MF CONTROL'))
            {
                $customerCredit += $credit;
                $customerDebit += $debit;
            }

        }
        
    }
}

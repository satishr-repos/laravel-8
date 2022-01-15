<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class CapitalGainHelper
{
    private $capitalGains;
    private $longTerm;
    private $shortTerm;
    private $spreadsheet;

    public function __construct($capitalGains, $shortTerm, $longTerm)
    {
        $template = Storage::path('private/CapitalGainTemplate.xlsx');
        $this->capitalGains = $capitalGains;
        $this->shortTerm = $shortTerm;
        $this->longTerm = $longTerm;
        $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
    }

    public function StoreResult($worksheet, $result)
    {
        if(!count($result))
            return;

        $row0 = $result[0];
        $keys = array_keys((array)$row0);

        foreach($keys as $index => $key)
            $worksheet->setCellValueByColumnAndRow($index + 1, 1, $key); 
        
        $worksheet->insertNewRowBefore(3, count($result) - 1);

        $i = 2;
        foreach($result as $row)
        {
            $j = 1;
            foreach($row as $key => $value)
            {
                $val = trim($value);
                $worksheet->setCellValueByColumnAndRow($j, $i, $val); 
                $j++;
            }

            $i++;
        }

        $sumRange = 'P2:P'.($i-1);
        $worksheet->setCellValue('P'.$i , "=SUM($sumRange)");
        
        $sumRange = 'Q2:Q'.($i-1);
        $worksheet->setCellValue('Q'.$i , "=SUM($sumRange)");
        
        $sumRange = 'R2:R'.($i-1);
        $worksheet->setCellValue('R'.$i , "=SUM($sumRange)");
        
        $sumRange = 'S2:S'.($i-1);
        $worksheet->setCellValue('S'.$i , "=SUM($sumRange)");

        foreach(range('A', 'T') as $col)
            $worksheet->getColumnDimension($col)->setAutoSize(true);
    }

    public function StoreResults()
    {
        $worksheet = $this->spreadsheet->getSheet(0);
        $result = $this->capitalGains;
        $this->StoreResult($worksheet, $result);
        
        $worksheet = $this->spreadsheet->getSheet(1);
        $result = $this->shortTerm;
        $this->StoreResult($worksheet, $result);

        $worksheet = $this->spreadsheet->getSheet(2);
        $result = $this->longTerm;
        $this->StoreResult($worksheet, $result);
    }

    public function GenerateExcel()
    {
        $fileName = uniqid('cg') . '.xlsx';

        $this->StoreResults();

        $output = Storage::path("public/$fileName");
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save($output);
        
        // $url = url('storage/'.$fileName);
        $url = $output;
        
        return $url;
    }

}

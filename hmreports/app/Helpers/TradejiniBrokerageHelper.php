<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;

class TradejiniBrokerageHelper
{
    private $spreadsheet;
    private $results;

    public function __construct($results)
    {
        $template = Storage::path('private/TradejiniTemplate.xlsx');
        $this->results = $results;
        $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
    }

    public function StoreResult($worksheet, $result)
    {
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

        foreach(range('A', 'S') as $col)
            $worksheet->getColumnDimension($col)->setAutoSize(true);
    }

    public function StoreResults()
    {
        if(count($this->results) != 1)
            throw new Exception("Invalid results from procLoadTradeJiniBrokerFile");

        $worksheet = $this->spreadsheet->getSheet(0);
        $result = $this->results[0];
        $this->StoreResult($worksheet, $result);
        
        // $worksheet = $this->spreadsheet->getSheet(1);
        // $result = $this->results[1];
        // $this->StoreResult($worksheet, $result);
    }

    public function GenerateExcel()
    {
        // $fileName = uniqid('qty') . '.xlsx';
        $fileName = 'Trade_Output.csv';

        $this->StoreResults();
        $output = Storage::path("public/$fileName");
        // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($this->spreadsheet);
        $writer->save($output);
        
        // $url = url('storage/'.$fileName);
        $url = $output;
        
        return $url;
    }

}

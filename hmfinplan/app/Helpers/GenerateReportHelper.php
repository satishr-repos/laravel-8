<?php

namespace App\Helpers;
// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Customer;

class GenerateReportHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function fillIncome(Worksheet $worksheet, Array $records, $title, $row)
    {
        if(isset($records))
        {
            $col = 'A';
            $cell = $col.$row;
            $worksheet->setCellValue($cell, $title);
            $items = $records;

            $row++;
            echo $cell;
            foreach($items as $item)
            {
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Type']);
                echo $cell .':' . $item['Type'] . ' ';

                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Monthly']);
                echo $cell .':' . $item['Monthly'] . ' ';
                
                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Annual']);
                echo $cell .':' . $item['Annual'] . ' ';

                $col = 'A';
                $row++;
            }
        }

        return $row;
    }

    public function incomeExpenseWorksheet(Worksheet $worksheet)
    {
        $ieHelper = new IncomeExpenseHelper($this->customer);

        $report = $ieHelper->report();

        $start = 5;
        $row = $start;
       
        $outflow = $report['outflow'];
        
        $row = $this->fillIncome($worksheet, $outflow['House Hold'], 'House Hold', $row);
        $row = $this->fillIncome($worksheet, $outflow['Monthly'], 'Monthly', $row);
        $row = $this->fillIncome($worksheet, $outflow['Luxury'], 'Luxury', $row);
        $row = $this->fillIncome($worksheet, $outflow['Annual'], 'Annual', $row);
        $row = $this->fillIncome($worksheet, $outflow['Savings'], 'Savings', $row);
        $row = $this->fillIncome($worksheet, array("prop" => $outflow['Proposed Investment']), '', $row);
        $row = $this->fillIncome($worksheet, array("surplus" => $outflow['Surplus']), '', $row);
        
        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getStyle('A5:F35')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function generateUrl()
    {
        $inputFileName = Storage::path('private/PlanTemplate.xlsx');
        $outputFileName = Str::random(10).'.xlsx';
        $outputFilePath = storage_path('app/public/'.$outputFileName);
   
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);

        if($spreadsheet->getSheetCount() === 8)
        {
            $worksheet = $spreadsheet->getSheet(1);
           
            $this->incomeExpenseWorksheet($worksheet);
            
            // Write an .xlsx file  
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); 
  
            // Save .xlsx file to the files directory 
            $writer->save($outputFilePath); 
        }

        return url('storage/'.$outputFileName);
    }
}
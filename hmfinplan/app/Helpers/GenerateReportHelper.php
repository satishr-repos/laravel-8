<?php

namespace App\Helpers;
// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Customer;
use Barryvdh\Debugbar\Facade as Debugbar;
use DateTime;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class GenerateReportHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    private function fullName($model)
    {
        if(isset($model))
            return "$model->first_name $model->middle_name $model->last_name";
        else
            return '';
    }

    public function PersonalReviewWorksheet(Worksheet $worksheet)
    {
        $customer = $this->customer;
        $personal = $this->customer->personalDetail;
        $family = $this->customer->familyMembers;
        $profession = $this->customer->professionalDetails;

        $date = new DateTime();

        $col = 'B';
        $row = 7;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->salutation.' '.$this->fullName($customer));

        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, "By ".$date->format('d-M-Y'));

        $col = 'C';
        $row = 14;
        
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->salutation.' '.$this->fullName($customer));
       
        $date = new DateTime($personal->dob);
        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $date->format('d-M-Y'));

        $spouse = null;
        foreach($family as $member)
        {
            if($member->relation === 'Spouse')
            {
                $spouse = $member;
                break;
            }
        }

        $row += 2;
        $cell = $col.$row;
        if(isset($spouse->wedding_date))
        {
            $date = new DateTime($spouse->wedding_date);
            $worksheet->setCellValue($cell, $date->format('d-M-Y'));
        }

        $occupation = null;
        $spouseOccupation = null;
        foreach($profession as $detail)
        {
            if($detail->name === $this->fullName($customer))
            {
                $occupation = $detail;
            }
            elseif($detail->name === $this->fullName($spouse))
            {
                $spouseOccupation = $detail;
            }
        }

        $row += 2;
        $cell = $col.$row;
        if(isset($occupation->title))
        {
            $worksheet->setCellValue($cell, $occupation->title.' @ '. $occupation->employer);
        }
        
        $row += 2;
        $cell = $col.$row;
        if(isset($occupation->title))
        {
            $worksheet->setCellValue($cell, $occupation->education);
        }

        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->pan);
        
        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->secondary_nos);

        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->primary_nos);

        $row += 2;
        $cell = $col.$row;
        if(isset($occupation->preferred_time))
        {
            $worksheet->setCellValue($cell, $occupation->preferred_time);
        }
        
        $row += 2;
        $cell = $col.$row;
        $worksheet->setCellValue($cell, $personal->primary_email);

        $row += 4;
        $cell = $col.$row;
        if(isset($spouseOccupation->title))
        {
            $worksheet->setCellValue($cell, $spouseOccupation->title.' @ '. $spouseOccupation->employer);
        }

        $row = 41;
        foreach($family as $member)
        {
            $col = 'B';

            $cell = $col.$row;
            $worksheet->setCellValue($cell, $member->salutation.' '.$this->fullName($member));

            $col++;
            $cell = $col.$row;
            $worksheet->setCellValue($cell, $member->relation);
            
            $col++;
            $cell = $col.$row;
            $date = new DateTime($member->dob);
            $worksheet->setCellValue($cell, $date->format('d-M-Y'));
            
            $col++;
            $cell = $col.$row;
            $worksheet->setCellValue($cell, $member->pan);

            $row++;
        }

    }

    public function fillIncome(Worksheet $worksheet, Array $records, $row, $end)
    {
        if(isset($records))
        {
            $col = 'D';

            foreach($records as $record)
            {
                if($record['Type'] === 'Total')
                    $row = $end;

                $cell = $col.$row;
                $worksheet->setCellValue($cell, $record['Type']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $record['Monthly']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $record['Annual']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
                $col = 'D';
                $row += 2;
            }
        }

        return $row;
    }

    public function fillExpense(Worksheet $worksheet, Array $records, $title, $row)
    {
        if(isset($records))
        {
            $col = 'A';
            $cell = $col.$row;
            $worksheet->setCellValue($cell, $title);
            $worksheet->getStyle($cell)->getFont()->setBold(true);
            $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $items = $records;

            $row++;
            foreach($items as $item)
            {
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Type']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Monthly']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
                $col++;
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $item['Annual']);
                $worksheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
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

        $start = 6;
        $row = $start;
       
        $outflow = $report['outflow'];
        $inflow = $report['inflow'];
        
        $row = $this->fillExpense($worksheet, $outflow['House Hold'], 'House Hold', $row);
        $row = $this->fillExpense($worksheet, $outflow['Monthly'], 'Monthly', $row);
        $row = $this->fillExpense($worksheet, $outflow['Luxury'], 'Luxury', $row);
        $row = $this->fillExpense($worksheet, $outflow['Annual'], 'Annual', $row);
        $row = $this->fillExpense($worksheet, $outflow['Savings'], 'Savings', $row);
        $row = $this->fillExpense($worksheet, array("prop" => $outflow['Proposed Investment']), '', $row);
        $row = $this->fillExpense($worksheet, array("surplus" => $outflow['Surplus']), '', $row);
        $row = $this->fillExpense($worksheet, array("total" => $outflow['Total']), '', 25);
       
        $row = $this->fillIncome($worksheet, $inflow, $start+1, 26);
        
        // $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        // $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
    }

    public function fillBalanceSheet(Worksheet $ws, $records, $title, $row, $start)
    {
        $col = $start;
        $cell = $col.$row;

        if(!empty($title))
        {
            $ws->setCellValue($cell, $title);
            $ws->getStyle($cell)->getFont()->setBold(true);
            $row++;
        }

        if(isset($records))
        {
            // Debugbar::info($records);
            foreach($records as $key => $value)
            {
                $cell = $col.$row;
                $ws->setCellValue($cell, $key);

                $col++;
                $cell = $col.$row;
                $ws->setCellValue($cell, $value);
                
                $col = $start;
                $row++;
            }
        }

        return $row;
    }

    public function balanceSheetWorksheet(Worksheet $worksheet)
    {
        $bsHelper = new BalanceSheetHelper($this->customer);
        $report = $bsHelper->report();

        $liabilities = $report['liabilities'];
        $assets = $report['assets'];

        $row = $this->fillBalanceSheet($worksheet, $liabilities['Short Term'], 'Short Term', 5, 'A');
        $row = $this->fillBalanceSheet($worksheet, $liabilities['Long Term'], 'Long Term', $row+1, 'A');
        $row = $this->fillBalanceSheet($worksheet, array('Net Worth' => $liabilities['Net Worth']), '', $row+1, 'A');
        $row = $this->fillBalanceSheet($worksheet, array('Total' => $liabilities['Total']), '', 25, 'A');

        $row = $this->fillBalanceSheet($worksheet, $assets['Tangible Assets'], 'Tangible Assets', 5, 'C');
        $row = $this->fillBalanceSheet($worksheet, $assets['Financial Assets'], 'Financial Assets', $row+1, 'C');
        $row = $this->fillBalanceSheet($worksheet, array('Total' => $assets['Total']), '', 25, 'C');
    }

    public function GoalsWorksheet(Worksheet $worksheet)
    {
        $glHelper = new GoalsHelper($this->customer);
        $goals = $glHelper->report();

        if(isset($goals))
        {
            // Debugbar::info($records);
            $row = 3;
            foreach($goals as $key=>$goal)
            {
                $col = 'A';
                if($key === count($goals) - 1) // Total value
                    $row = 15;
                foreach($goal as $index=>$value)
                {
                    if($index == 0)
                    {
                        $value = $key + 1;
                    }

                    $cell = $col.$row;
                    $worksheet->setCellValue($cell, $value);
                    $col++;
                }

                $row++;
            }
        }
    }

    public function RiskMgmtWorksheet(Worksheet $worksheet)
    {
        $rkHelper = new RiskManagementHelper($this->customer);
        $report = $rkHelper->report();

        $rkMgmt = $report['Risk Management'];

        if(isset($rkMgmt))
        {
            // Debugbar::info($records);
            $index = 1;
            $row = 2;
            foreach($rkMgmt as $key=>$value)
            {
                $col = 'A';

                $cell = $col.$row;
                $worksheet->setCellValue($cell, $index);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $key);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $value);

                $index++;
                $row++;
            }
        }
        
        $availRscs = $report['Available Resources'];

        if(isset($availRscs))
        {
            // Debugbar::info($records);
            $index = 1;
            $row++;
            foreach($availRscs as $key=>$value)
            {
                $col = 'A';

                $cell = $col.$row;
                $worksheet->setCellValue($cell, $index);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $key);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $value);

                $index++;
                $row++;
            }
        }
    }

    public function LivingExpensesWorksheet(Worksheet $worksheet)
    {
        $leHelper = new LivingExpensesHelper($this->customer);
        $report = $leHelper->report();

        if(isset($report))
        {
            // Debugbar::info($records);
            $index = 1;
            $row = 2;
            foreach($report as $key=>$value)
            {
                $col = 'A';

                $cell = $col.$row;
                $worksheet->setCellValue($cell, $index);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $key);
                $col++;
                
                $cell = $col.$row;
                $worksheet->setCellValue($cell, $value);

                $index++;
                $row++;
            }
        }
    }

    public function CashFlowWorksheet(Worksheet $worksheet)
    {
        $cfHelper = new CashFlowHelper($this->customer);
        $reports = $cfHelper->report();

        if(isset($reports))
        {
            $worksheet->insertNewRowBefore(9, count($reports) - 1);
            $i = 1;
            $row = 8;
            foreach($reports as $report)
            {
                $col = 'A';
                foreach($report as $key=>$value)
                {
                    $cell = $col.$row;
                    $worksheet->setCellValue($cell, $value);
                    $col++;

                    if($i === count($reports))
                    {
                        $worksheet->getStyle($cell)->getFont()->setBold(true);
                    }
                }

                $row++;
                $i++;
            }
            
            $worksheet->getColumnDimension('A')->setAutoSize(true);
            $worksheet->getColumnDimension('B')->setAutoSize(true);
            $worksheet->getColumnDimension('C')->setAutoSize(true);
            $worksheet->getColumnDimension('D')->setAutoSize(true);
            $worksheet->getColumnDimension('E')->setAutoSize(true);
            $worksheet->getColumnDimension('F')->setAutoSize(true);
            $worksheet->getColumnDimension('G')->setAutoSize(true);
            $worksheet->getColumnDimension('H')->setAutoSize(true);
            $worksheet->getColumnDimension('I')->setAutoSize(true);
        }
    }

    public function EpfWorksheet(Worksheet $templSheet, Spreadsheet $spreadsheet)
    {
        $pfHelper = new EpfHelper($this->customer);
        $reports = $pfHelper->report();

        $worksheets = array($templSheet);
        for($i=1; $i < count($reports); $i++)
        {
            $clonedWorksheet = clone $templSheet; 
            $clonedWorksheet->setTitle('PF CAL'.$i);
            $spreadsheet->addSheet($clonedWorksheet);
            array_push($worksheets, $clonedWorksheet);
        }

        for($i=0; $i < count($reports); $i++)
        {
            $worksheet = $worksheets[$i];

            $pfData = $reports[$i]['epf_data'] ?? null;
            $pfReport = $reports[$i]['epf_report'] ?? null;

            if(isset($pfData))
            {
                $col = 'A';
                foreach($pfData as $key=>$value)
                {
                    if($key === 'Employer Contribution')
                    {
                        $row = 5;
                        $col = 'E';
                    }
                    else
                    {
                        $row = 3;
                    }

                    $cell = $col.$row;
                    $worksheet->setCellValue($cell, $value);
                    $col++;
                }
            }

            if(isset($pfReport))
            {
                $worksheet->insertNewRowBefore(10, count($pfReport) - 1);
                $row = 9;
                foreach($pfReport as $report)
                {
                    $col = 'A';
                    foreach($report as $key=>$value)
                    {
                        $cell = $col.$row;
                        $worksheet->setCellValue($cell, $value);
                        $col++;
                    }

                    $row++;
                }
            }

            $worksheet->getColumnDimension('A')->setAutoSize(true);
            $worksheet->getColumnDimension('B')->setAutoSize(true);
            $worksheet->getColumnDimension('C')->setAutoSize(true);
            $worksheet->getColumnDimension('D')->setAutoSize(true);
            $worksheet->getColumnDimension('E')->setAutoSize(true);
            $worksheet->getColumnDimension('F')->setAutoSize(true);
            $worksheet->getColumnDimension('G')->setAutoSize(true);
            $worksheet->getColumnDimension('H')->setAutoSize(true);

        }

    }

    public function generateUrl($fileType)
    {
        $inputFileName = Storage::path('private/PlanTemplate.xlsx');
        $outputFileName = '';
   
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);

        if($spreadsheet->getSheetCount() === 8)
        {
            $worksheet = $spreadsheet->getSheet(0);
            $this->PersonalReviewWorksheet($worksheet);

            $worksheet = $spreadsheet->getSheet(1);
            $this->incomeExpenseWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(2);
            $this->balanceSheetWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(3);
            $this->GoalsWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(4);
            $this->RiskMgmtWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(5);
            $this->LivingExpensesWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(6);
            $this->CashFlowWorksheet($worksheet);
            
            $worksheet = $spreadsheet->getSheet(7);
            $this->EpfWorksheet($worksheet, $spreadsheet);
            
            $spreadsheet->setActiveSheetIndex(1);
           
            if($fileType === 'xlsx')
            {
                // Write an .xlsx file  
                $outputFileName = Str::random(10).'.xlsx';
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); 
            }
            else
            {
                $outputFileName = Str::random(10).'.pdf';
               
                for($i=0; $i < $spreadsheet->getSheetCount(); $i++)
                {
                    $ws = $spreadsheet->getSheet($i); 
                    $ws->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                    // $ws->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
                    $ws->getPageSetup()->setFitToWidth(1);
                    $ws->getPageSetup()->setFitToHeight(0);
                    // $ws->getPageSetup()->setFitToPage(true);
                    // $ws->getPageSetup()->setScale(80);
                    // $ws->getPageMargins()->setTop(1);
                    // $ws->getPageMargins()->setRight(0.25);
                    // $ws->getPageMargins()->setLeft(0.25);
                    // $ws->getPageMargins()->setBottom(1);
                    $ws->setShowGridlines(false);
                }

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf($spreadsheet);
                $writer->setFont('freeserif');

                $writer->writeAllSheets();
            }
  
            $outputFilePath = storage_path('app/public/'.$outputFileName);
            $writer->save($outputFilePath); 
        }

        return url('storage/'.$outputFileName);
    }
}
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\PmsBillLedgerHelper;
use DateTime;
use Exception;

class PmsBillLedger extends Component
{
    public $start_date;
    public $end_date;
    public $exception;
    public $url;

    protected $rules = [
        'start_date' => 'required|date|before:tomorrow',
        'end_date' => 'required|date|before:tomorrow',
    ];

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function submit()
    {
        $this->validate();

        $this->exception = '';
        $startDate = str_replace('-', '/', $this->start_date);
        $endDate = str_replace('-', '/', $this->end_date);

        try
        {
            $pdo = DB::connection("sqlsrv")->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $syntax = "set nocount on;exec dbo.procPMSBillLedgerComp '$startDate', '$endDate';";
            $query = $pdo->prepare($syntax,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
            $exec = $query->execute();
            if(empty($exec))
                throw new Exception('No data received from the server for this query');
        
            $results = [];
            do {
                try {
                    $results[] = $query->fetchAll(\PDO::FETCH_OBJ);
                } catch (\Exception $ex) {
        
                }
            } while ($query->nextRowset());
    
    
            // if (1 === count($results)) return $results[0];
            // return $results;
            Log::info($results);
            
            $helper = new PmsBillLedgerHelper($results);
            $this->url = $helper->GenerateExcel();

        }
        catch(Exception $e)
        {
            $this->exception = $e->getMessage();
        }

    }

    public function Download()
    {
        return response()->download($this->url);
    }

    public function render()
    {
        return view('livewire.pms-bill-ledger');
    }
}

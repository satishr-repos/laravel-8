<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\CapitalGainHelper;
use DateTime;
use Exception;

class CapitalGain extends Component
{
    public $name;
    public $start_date;
    public $end_date;
    public $exception;
    public $url;
    
    protected $rules = [
        'name' => 'required',
        'start_date' => 'required|date|before:end_date',
        'end_date' => 'required|date',
    ];

    public function mount()
    {
        $this->name = "";
        $year = (int)date('Y');
        $this->start_date = ($year-1).'-04-01';
        $this->end_date = "$year-03-31";
    }

    public function submit()
    {
        $this->validate();

        $shortTerm = [];
        $longTerm = [];
        $capitalGains = [];
        $this->exception = '';

        $name = '';

        try
        {
            // $pdo = DB::connection("sqlsrv")->getPdo();
            // $query = $pdo->prepare("set nocount on;exec dbo.procFIFOCapitalGain @Investor_Name='$this->name'");
            // $query->execute();
            // $capital_gains = $query->fetchAll(\PDO::FETCH_OBJ);
            $output = DB::connection("sqlsrv")->select("set nocount on;exec dbo.procFIFOCapitalGain @Investor_Name='$this->name'");

            if(empty($output))
                throw new Exception('No data received from the server for this query');

            foreach($output as $capitalGain)
            {
                $start = new DateTime($this->start_date);
                $end = new DateTime($this->end_date);
                $trdt = new DateTime($capitalGain->S_Trdt);

                $name = $capitalGain->Investor_Name;

                // unset($capitalGain->Pan_No);
                // unset($capitalGain->Investor_Name);
                if($trdt >= $start && $trdt <= $end)
                {
                    array_push($capitalGains, $capitalGain);

                    if($capitalGain->Gain_Type === 'LongTerm')
                    {
                        array_push($longTerm, $capitalGain);
                    }
                    else
                    {
                        array_push($shortTerm, $capitalGain);
                    }

                }

            }

            $helper = new CapitalGainHelper($capitalGains, $shortTerm, $longTerm, $name);
            $this->url = $helper->GenerateExcel();
        }
        catch(Exception $e)
        {
            $this->exception = $e->getMessage();
        }

        Log::info($capitalGains);
    }

    public function CGDownload()
    {
        return response()->download($this->url);
    }

    public function render()
    {
        return view('livewire.capital-gain');
    }
}

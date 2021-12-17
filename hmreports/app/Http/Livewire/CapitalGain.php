<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;
use Exception;

class CapitalGain extends Component
{
    public $name;
    public $start_date;
    public $end_date;
    public $exception;
    private $capital_gains;
    
    protected $rules = [
        'name' => 'required',
        'start_date' => 'required|date|before:end_date',
        'end_date' => 'required|date',
    ];

    public function mount()
    {
        $this->name = "";
        $this->start_date = '2020-04-01';
        $this->end_date = '2021-03-31';
        $this->capital_gains = '';
    }

    public function submit()
    {
        $this->validate();

        $this->capital_gains = [];
        $this->exception = '';

        try
        {
            // $pdo = DB::connection("sqlsrv")->getPdo();
            // $query = $pdo->prepare("set nocount on;exec dbo.procFIFOCapitalGain @Investor_Name='$this->name'");
            // $query->execute();
            // $capital_gains = $query->fetchAll(\PDO::FETCH_OBJ);
            $capital_gains = DB::connection("sqlsrv")->select("set nocount on;exec dbo.procFIFOCapitalGain @Investor_Name='$this->name'");

            if(empty($capital_gains))
                throw new Exception('No data received from the server for this query');

            foreach($capital_gains as $capital_gain)
            {
                $start = new DateTime($this->start_date);
                $end = new DateTime($this->end_date);
                $trdt = new DateTime($capital_gain->S_Trdt);

                if($trdt >= $start && $trdt <= $end)
                {
                    array_push($this->capital_gains, $capital_gain);
                }

            }
        }
        catch(Exception $e)
        {
            $this->exception = $e->getMessage();
        }

        // Log::info($this->capital_gains);
    }

    public function render()
    {
        return view('livewire.capital-gain');
    }
}

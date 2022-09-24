<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\HighValueTransHelper;
use Exception;

class HighValueTrans extends Component
{
    public $strategy;
    public $client;
    public $exception;
    public $url;

    protected $rules = [
        'strategy' => 'required',
        'client' => 'required',
    ];

    public function mount()
    {
    }

    public function submit()
    {
        $this->validate();

        $this->exception = '';

        try
        {
            $pdo = DB::connection("sqlsrv")->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $syntax = "set nocount on;exec dbo.procHighValueTrans '$this->strategy', '$this->client';";
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
            
            $helper = new HighValueTransHelper($results);
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
        return view('livewire.high-value-trans');
    }
}

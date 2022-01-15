<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\OrbisCustodyFileHelper;
use DateTime;
use Exception;


class OrbisCustodyFile extends Component
{
    public $date;
    public $exception;
    public $url;

    protected $rules = [
        'date' => 'required|date|before:tomorrow',
    ];

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function submit()
    {
        // $this->validate();

        $this->exception = '';
        $date = str_replace('-', '/', $this->date);

        try
        {
            $pdo = DB::connection("sqlsrv")->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $syntax = "set nocount on;exec dbo.procOrbisCustdyFileGen '$date';";
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
            
            $helper = new OrbisCustodyFileHelper($results);
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
        return view('livewire.orbis-custody-file');
    }
}

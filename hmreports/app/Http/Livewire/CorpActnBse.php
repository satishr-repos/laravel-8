<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CorpActnHelper;
use Livewire\WithFileUploads;
use Exception;
use File;

class CorpActnBse extends Component
{
    use WithFileUploads;

    public $exception;
    public $url;
    public $inputFile;
    public $inputPath;
    public $corpActn;
   
    public function mount()
    {
        $y = date('Y');
        $m = date('m');
        $d = date('d');

        $this->inputFile = "BSE_INPUT$y$m$d.csv";
        $this->inputPath = "D:\VIGNESH\CORPORATEACTION\FY_2021-22\BSE";
    }
 
    public function save()
    {
        $this->validate([
            'corpActn' => 'file|max:32764', // 32MB Max
        ]);
 
        $this->corpActn->storeAs('uploads', $this->inputFile);
        $src = Storage::path("uploads/$this->inputFile");
        $dest = join(DIRECTORY_SEPARATOR, array($this->inputPath, $this->inputFile));

        // Log::info($src);
        // Log::info($dest);
        File::copy($src, $dest);
    }

    public function submit()
    {
        // $this->validate();

        $this->exception = '';

        try
        {
            $dest = join(DIRECTORY_SEPARATOR, array($this->inputPath, $this->inputFile));
            if(!file_exists($dest))
                throw new Exception("BSE_INPUT file not found. Upload the file to proceed");

            $pdo = DB::connection("sqlsrv")->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $syntax = "set nocount on;exec dbo.procCorpActnBSE @FolderPath='1'";
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
            
            $helper = new CorpActnHelper($results);
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
        return view('livewire.corp-actn-bse');
    }
}

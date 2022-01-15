<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ShareproReconHelper;
use Livewire\WithFileUploads;
use Exception;
use File;

class ShareproRecon extends Component
{
    use WithFileUploads;

    public $exception;
    public $url;
    public $inputFile;
    public $inputPath;
    public $file;

    public function mount()
    {

        $this->inputFile = "DP_Orbis_Recon.csv";
        $this->inputPath = "D:\VIGNESH\DP RECON";
    }
    
    public function save()
    {
        $this->validate([
            'file' => 'file|max:32764', // 32MB Max
        ]);
 
        $this->file->storeAs('uploads', $this->inputFile);
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
                throw new Exception("DP_Orbis_Recon.csv file not found. Upload the file to proceed");

            $pdo = DB::connection("sqlsrv")->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $syntax = "set nocount on;exec dbo.procDPShareproQtyRecon @FolderPath='1'";
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
            
            $helper = new ShareproReconHelper($results);
            $this->url = $helper->GenerateExcel();

            Log::info($results);
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
        return view('livewire.sharepro-recon');
    }
}

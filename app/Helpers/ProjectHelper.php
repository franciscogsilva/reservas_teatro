

<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
    
    /**
     * Create chairs in database.
     *
     * @return App\Chair
     */
    function setChairs(){
        $i = 1;
        for ($row=1; $row<=5; $row++) {
            for ($column=1; $column<=10; $column++) { 
                $chair = new App\Chair();
                $chair->id = $i;
                $chair->row = $row;
                $chair->column = $column;
                $chair->save();
                $i++;
            }
        }

        return App\Chair::orderBy('id', 'ASC')->get();
    }

    function setLog($log, $title){
        \Log::info($log);
        
        $logFile = $title.'_'.Carbon::now()->format('Ymd_His').'.txt';
        Storage::disk('local')->put($logFile, print_r($log, true));
    }
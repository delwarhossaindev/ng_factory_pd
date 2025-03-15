<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Bus;

class Import 
{   
    /**
     * Summary of import
     * @param mixed $request
     * @param mixed $jobClass
     * @param mixed $chunk
     * @return \Illuminate\Bus\Batch|string
     */
    public function import($request, $jobClass, $chunk)
    {
        if($request->has('csv')) {
            $csv    = file($request->csv);
            $chunks = array_chunk($csv,$chunk);
            $header = [];
            $batch  = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $row) {
            $data = array_map('str_getcsv', $row);
                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }
                $batch->add(new $jobClass($data, $header));
            }
            
            return $batch;
        }

        return 'please upload csv file';
    }
}
<?php

namespace App\Jobs;

use Throwable;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class UserBulkUpload implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $header;
    public $data;
    
    /**
     * Summary of __construct
     * @param mixed $data
     * @param mixed $header
     */
    public function __construct($data, $header)
    {
        $this->data = $data;
        $this->header = $header;
    }
    
    /**
     * Summary of handle
     * @return void
     */
    public function handle()
    {
        try {
            foreach ($this->data as $user) {
                $data = array_combine($this->header,$user);
                User::create($data);
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function failed(Throwable $exception)
    {
        Log::info($exception->getMessage());
    }
}

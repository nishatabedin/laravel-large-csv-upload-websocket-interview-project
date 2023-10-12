<?php

namespace App\Jobs\Product;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Product\UploadHistory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StoreProductDataByCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $data;
    public $header;
    public $batchId;
    public $fileHash;
    public $uploadHistoryId;
  
    public function __construct($data, $header, $fileHash, $uploadHistoryId)
    {
        $this->data = $data;
        $this->header = $header;
        $this->fileHash = $fileHash;
        $this->uploadHistoryId = $uploadHistoryId;
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->updateStatus($this->uploadHistoryId , 'Processing');
        $upsertData = [];
        foreach ($this->data as $product) {
            $productInput = array_combine($this->header, $product);
            // Filter the data to keep only the fields in the $fillable array
            $filteredData = array_intersect_key($productInput, array_flip([
                'UNIQUE_KEY',
                'PRODUCT_TITLE',
                'PRODUCT_DESCRIPTION',
                'STYLE#',
                'SANMAR_MAINFRAME_COLOR',
                'SIZE',
                'COLOR_NAME',
                'PIECE_PRICE',
            ]));
    
            // Append the filtered data to the upsertData array
            $upsertData[] = $filteredData;
        }


        //handling deadlock
        DB::transaction(function ()use ($upsertData){
            //Will run only one query to upsert for every chunk
            Product::upsert($upsertData, ['UNIQUE_KEY'], [ 
                'PRODUCT_TITLE',
                'PRODUCT_DESCRIPTION',
                'STYLE#',
                'SANMAR_MAINFRAME_COLOR',
                'SIZE',
                'COLOR_NAME',
                'PIECE_PRICE',
            ]);
        }, 5);




        if ($this->batch()->progress() > 95) {
            $this->updateStatus($this->uploadHistoryId , 'Completed');

            // Notify user for the completion of the upload process  (To DO)
        }

        
    }


    public function withBatchId($batchId)
    {
        $this->batchId = $batchId;
        return $this;
    }


    private function updateStatus($uploadHistoryId, $status)
    {
        $uploadHistory = UploadHistory::find($uploadHistoryId);
        $uploadHistory->update(['upload_status' => $status]);
    }


    


}

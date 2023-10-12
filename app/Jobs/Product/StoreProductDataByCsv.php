<?php

namespace App\Jobs\Product;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
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

  
    public function __construct($data, $header, $fileHash)
    {
        $this->data = $data;
        $this->header = $header;
        $this->fileHash = $fileHash;
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {
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

        
    }


    public function withBatchId($batchId)
    {
        $this->batchId = $batchId;
        return $this;
    }


}

<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use App\Models\Product\UploadHistory;
use App\Jobs\Product\StoreProductDataByCsv;
use App\Events\Product\CsvUploadHistoryEvent;

class ProductImportController extends Controller
{


    public function upload_history(){
        return UploadHistory::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
    }

    

    public function store(Request $request)
    {
        $csvFile = $request->file('csv');
        $uploadHistory= UploadHistory::create([
            'filename' => $csvFile->getClientOriginalName(),
            'uploaded_at' => now(),
            'upload_status' => 'Pending',
            'user_id' => auth()->user()->id,
        ]);

        $fileContents = file_get_contents($csvFile->getRealPath());
        $fileHash = md5($fileContents);
        // Split the file contents into chunks
        $lines = explode("\n", $fileContents);
        $chunks = array_chunk($lines, 1000);
        $header = [];
        $batch  = Bus::batch([])->dispatch();
        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
            if ($key == 0) {
                $header = $data[0];
                unset($data[0]);
            }
            $batch->add(new StoreProductDataByCsv($data, $header, $fileHash,  $uploadHistory->id ));
        }

        return redirect()->route('dashboard')
        ->with('success', 'CSV Import added to the queue. We will update you once done.');

    }
}

<?php

namespace App\Http\Controllers\Product;

use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use App\Models\Product\UploadHistory;
use App\Jobs\Product\StoreProductDataByCsv;
use App\Http\Requests\Product\UploadCsvRequest;
use App\Notifications\Csv\CsvUploadJobFinishedNotification;


class ProductImportController extends Controller
{


    public function upload_history(){
        return UploadHistory::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
    }

    

    public function store(UploadCsvRequest $request)
    {

        $fileHash = $request->fileHash; 
        $header = $request->header; 
        $validRows = $request->validRows; 

        $uploadHistory= UploadHistory::create([
            'filename' => $request->getClientOriginalName(),
            'uploaded_at' => now(),
            'upload_status' => 'Pending',
            'user_id' => auth()->user()->id,
        ]);

        $chunks = array_chunk($validRows, 500);
        $batch = Bus::batch([]);
        foreach ($chunks as $key => $chunk) {
            $batch->add(new StoreProductDataByCsv($chunk, $header, $fileHash,  $uploadHistory->id ));
        }

        $batch->finally(function () use ($uploadHistory, $fileHash) {
            if ($uploadHistory->upload_status !== 'Failed') {
                $uploadHistory->update(['upload_status' => 'Completed']);
                $uploadHistory->update(['file_hash' => $fileHash]);
            }
            // Notify user for the completion of the upload process
            $uploadedByUser = $uploadHistory->user;
            $uploadedByUser->notify(new CsvUploadJobFinishedNotification());
        })->dispatch();

        return redirect()->route('dashboard')
        ->with('success', 'CSV Import added to the queue. We will update you once done.');

    }



}

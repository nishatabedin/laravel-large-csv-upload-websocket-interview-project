<?php

namespace App\Observers;


use App\Models\Product\UploadHistory;
use App\Events\Product\CsvUploadHistoryEvent;

class UploadHistoryObserver
{
    /**
     * Handle the UploadHistory "created" event.
     */
    public function created(UploadHistory $uploadHistory): void
    {
       // dd($uploadHistory);
        event(new CsvUploadHistoryEvent($uploadHistory));
    }

    /**
     * Handle the UploadHistory "updated" event.
     */
    public function updated(UploadHistory $uploadHistory): void
    {
        event(new CsvUploadHistoryEvent($uploadHistory));
    }



   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestingWsEvent;
use App\Events\Product\CsvUploadHistoryEvent;

class TestWsEventController extends Controller
{
    function testingWsEvents()
    {

        $customData = [
            'time' => 'time',
            'filename' => 'filename',
            'uploadStatus' => 'uploadStatus',
        ];
        event(new CsvUploadHistoryEvent($customData));

        //event(new TestingWsEvent('test'));
    }
}

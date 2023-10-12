<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestingWsEvent;

class TestWsEventController extends Controller
{
    function testingWsEvents()
    {
     event(new TestingWsEvent);
    }
}

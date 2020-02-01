<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Channeltype;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function channellist()
    {
        return Channeltype::list();
    }
}

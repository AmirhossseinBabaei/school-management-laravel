<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function downloadApkFile()
    {
        return response()->download(public_path('/applications/android.apk'));
    }
}

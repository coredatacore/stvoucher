<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Radacct;
use App\Models\Radpostauth;

class LogController extends Controller
{
    public function accounting(Request $request)
    {
        $logs = Radacct::orderBy('radacctid', 'desc')->paginate(30);
        return view('admin.logs.accounting', compact('logs'));
    }

    public function auth(Request $request)
    {
        $logs = Radpostauth::orderBy('id', 'desc')->paginate(30);
        return view('admin.logs.auth', compact('logs'));
    }
}
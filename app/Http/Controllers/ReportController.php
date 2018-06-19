<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\LE2;

class ReportController extends Controller
{
    public function index()
    {
        $data['Cards'] = LE2::all();

        return view('LE2.index', $data);
    }
}

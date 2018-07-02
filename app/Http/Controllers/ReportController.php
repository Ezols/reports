<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\LE2;
use App\LE1;

class ReportController extends Controller
{
    public function leob1()
    {
        $data['Cards'] = LE1::orderBy('ct_contact_date', 'desc')->get();
        return view('LE1.index', $data);
    }

    public function leob2()
    {
        $data['Cards'] = LE2::orderBy('ct_contact_date', 'desc')->get();
        return view('LE2.index', $data);
    }

    public function passage()
    {
        $data['Cards'] = DB::select(DB::raw("
                SELECT   

                distinct a.code, 
                a.termination_status,
                b.start_time,
                global_call.contact,
                global_call.ph_number,
                segment.e_user,
                ct_LV_PASSAGE_OB.*

                FROM    

                call_thread a INNER JOIN
                thread b ON a.code = b.code join
                global_call ON a.global_call = global_call.code join
                ph_contact ON global_call.contact = ph_contact.code join
                segment ON segment.thread = b.code join
                ct_LV_PASSAGE_OB on global_call.contact = ct_LV_PASSAGE_OB.easycode

                WHERE     

                (b.start_time >= '2018-06-20 00:00')

                AND (ph_contact.campaign = 1212);
            ")
        );

        return view('Passage.index', $data);
    }
}

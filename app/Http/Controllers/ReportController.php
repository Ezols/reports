<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\LE2;
use App\LE1;
use Excel;
use App\Passage;
use Illuminate\Support\Carbon;

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

    public function latvenergo()
    {
        $data['leob1'] = DB::select(
            DB::raw(
                "SELECT *, 
                ph_contact.status  
                from ct_LV_OB_Latvener1 
                join ph_contact 
                on ct_LV_OB_Latvener1.easycode = dbo.ph_contact.code 
                where (ct_call_type_id is NULL or ct_call_type_id = '999') 
                and (ph_contact.status <> '17' and ph_contact.status <> '6' and ph_contact.status <> '3') 
                order by easycode desc;
                "
            )
        );

        $data['leob2'] = DB::select(
            DB::raw(
                "SELECT *, 
                ph_contact.status  
                from ct_LV_OB_Latvener2 
                join ph_contact 
                on ct_LV_OB_Latvener2.easycode = dbo.ph_contact.code 
                where (ct_call_type_id is NULL or ct_call_type_id = '999') 
                and (ph_contact.status <> '17' and ph_contact.status <> '6' and ph_contact.status <> '3') 
                order by easycode desc;
                "
            )
        );
        return view('latvenergo', $data);
    }

    public function passage()
    {    
        return view('Passage.index');
    }    

    public function exportPassage()
    {
        $this->validate(request(), [
            "startDate" => "nullable|date",
            "endDate" => "nullable|date",
        ]);
        
        $from = Carbon::createFromFormat('Y-m-d\TH:i', request()->startDate)->format('Y-m-d H:i');
        $to = Carbon::CreateFromFormat('Y-m-d\TH:i', request()->endDate)->format('Y-m-d H:i');     
      

        if(request()->display)
        {
            $data['cards'] = $this->querry($from, $to);

            return view('passage.index', $data);
        }
        else if(request()->submit)
        {
            $file = Excel::create('Passage', function($excel) use ($from, $to)
            {
                $excel->sheet('Passage', function($sheet) use ($from, $to)
                {              
                    $data['exports'] = $this->querry($from, $to);
                    $sheet->loadView('excel', $data);
                });
            })->export('xls');
        }         
    }

    private function querry($from, $to)
    {
        $querry = DB::select(
            DB::raw(
            "SELECT   

            distinct a.code, 
            a.termination_status,
            b.start_time,
            global_call.contact,
            global_call.ph_number,
            segment.e_user,
            ct_LV_PASSAGE_OB.easycode,
            ct_LV_PASSAGE_OB.ct_agent,
            ct_LV_PASSAGE_OB.ct_contact_date,
            ct_LV_PASSAGE_OB.ct_call_type,
            ct_LV_PASSAGE_OB.ct_call_type_name,
            ct_LV_PASSAGE_OB.ct_call_type_desc,
            ct_LV_PASSAGE_OB.ct_call_type_id,
            ct_LV_PASSAGE_OB.ct_batch_name,
            ct_LV_PASSAGE_OB.ct_load_date,
            ct_LV_PASSAGE_OB.ct_num_calls,
            ct_LV_PASSAGE_OB.ct_num_recalls,
            ct_LV_PASSAGE_OB.ct_duration,
            ct_LV_PASSAGE_OB.ct_talk_time,
            ct_LV_PASSAGE_OB.ct_comments,
            ct_LV_PASSAGE_OB.ct_phone1,
            ct_LV_PASSAGE_OB.ct_phone_callback,
            ct_LV_PASSAGE_OB.ct_name,
            ct_LV_PASSAGE_OB.ct_surname,
            ct_LV_PASSAGE_OB.ct_cust1_text01

            FROM    

            -- call_thread a INNER JOIN
            -- thread b ON a.code = b.code join
            -- global_call ON a.global_call = global_call.code join
            -- ph_contact ON global_call.contact = ph_contact.code join
            -- segment ON segment.thread = b.code join
            -- ct_LV_PASSAGE_OB on global_call.contact = ct_LV_PASSAGE_OB.easycode

            call_thread a WITH(NOLOCK)
            INNER JOIN thread b WITH(NOLOCK) ON a.code = b.code 
            join global_call WITH(NOLOCK) ON a.global_call = global_call.code 
            join ph_contact WITH(NOLOCK) ON global_call.contact = ph_contact.code 
            join segment WITH(NOLOCK) ON segment.thread = b.code 
            join ct_LV_PASSAGE_OB WITH(NOLOCK) on global_call.contact = ct_LV_PASSAGE_OB.easycode

            WHERE
        
            (b.start_time >= '$from')
            AND
            (b.start_time <= '$to')

            AND (ph_contact.campaign = 1212);"
        ));
        return $querry;
    }
}

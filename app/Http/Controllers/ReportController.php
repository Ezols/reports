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
            $data['cards'] = $this->statusQuerry($from, $to);

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
            "SELECT  DISTINCT
            a.code, 
			ph_contact.status,
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
			(SELECT MAX(code) code, contact FROM data_context WHERE campaign=1212 GROUP BY contact) dc
            INNER JOIN (SELECT MAX(code) code, data_context FROM thread WITH(NOLOCK)
							WHERE start_time BETWEEN '$from' AND '$to'
							GROUP BY data_context) th ON dc.code=th.data_context
			INNER JOIN thread b WITH(NOLOCK) ON th.code=b.code
			INNER JOIN call_thread a WITH(NOLOCK) ON a.code = b.code 
            join global_call WITH(NOLOCK) ON a.global_call = global_call.code 
            join ph_contact WITH(NOLOCK) ON global_call.contact = ph_contact.code 
            join segment WITH(NOLOCK) ON segment.thread = b.code 
            join ct_LV_PASSAGE_OB WITH(NOLOCK) on global_call.contact = ct_LV_PASSAGE_OB.easycode
            join ct_LV_PASSAGE_OB AS Passage WITH(NOLOCK) on Passage.easycode = ph_contact.code		

            ORDER BY 8;"
        ));
        return $querry;
    }

    private function statusQuerry($from, $to)
    {
        $querry = DB::select(
            DB::raw(
            "SELECT  DISTINCT
            a.code, 
			ph_contact.status,
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
			(SELECT MAX(code) code, contact FROM data_context WHERE campaign=1212 GROUP BY contact) dc
            INNER JOIN (SELECT MAX(code) code, data_context FROM thread WITH(NOLOCK)
							WHERE start_time BETWEEN '$from' AND '$to'
							GROUP BY data_context) th ON dc.code=th.data_context
			INNER JOIN thread b WITH(NOLOCK) ON th.code=b.code
			INNER JOIN call_thread a WITH(NOLOCK) ON a.code = b.code 
            join global_call WITH(NOLOCK) ON a.global_call = global_call.code 
            join ph_contact WITH(NOLOCK) ON global_call.contact = ph_contact.code 
            join segment WITH(NOLOCK) ON segment.thread = b.code 
            join ct_LV_PASSAGE_OB WITH(NOLOCK) on global_call.contact = ct_LV_PASSAGE_OB.easycode
            join ct_LV_PASSAGE_OB AS Passage WITH(NOLOCK) on Passage.easycode = ph_contact.code
				

            WHERE
            
            status in (0,3)

            ORDER BY ph_contact.status ASC;"
        ));
        return $querry;
    }
}


// 0 - Start. Must be made.
// 1 - Exec. Ongoing contact.
// 2 - Stop. Call terminated abnormally.
// 3 - Done. Call successfully completed.
// 6 - Agent death. Aborted because the agent performed a manual or automatic cleanup.
// 8 - Invalid contact. Contact does not have an entry in the table attributes.
// 9 - Reject contact. It has been impossible to bring attributes up to date on the database or a phone type used for the contact is not defined.
// 10 - Created. Contact created for inbound.
// 11 - Lock. Contact loaded by an agent.
// 15 - In use by the Assisted Server. Internal use.
// 16 - In use by the Assisted Server. Internal use.
// 17 - Abort. Outbound contact abandoned.
// 18 - Exec Recover. Ongoing contact in recovery process after the Assisted Server crashed.
// 19 - Loc Recover. Contact loaded by an agent in recovery process after the Assisted Server crashed.
// 100 - Logically deleted contact - you shouldn't really encounter this

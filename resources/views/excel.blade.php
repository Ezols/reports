<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>

<table class="table">
    <tr>
        <th>Easycode</th>
        <th>Start time</th>
        <th>Termination status</th>
        <th>Agent</th>
        <th>Contact date</th>
        <th>Call type ID</th>
        <th>Call type</th>
        <th>Call type name</th>
        <th>Call type desc</th>
        <th>Batch name</th>
        <th>Load date</th>
        <th>Num. calls</th>
        <th>Num. recalls</th>
        <th>Duration</th>
        <th>Talk time</th>
        <th>Comments</th>
        <th>Phone1</th>
        <th>Phone callback</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Text1</th>
    </tr>

    @foreach($exports as $export)
        <tr>
            <td>{{ $export->easycode }}</td>
            <td>{{ $export->start_time }}</td>
            <td>{{ $export->termination_status }}</td>
            <td>{{ $export->ct_agent }}</td>
            <td>{{ $export->ct_contact_date }}</td>
            <td>{{ $export->ct_call_type_id }}</td>
            <td>{{ $export->ct_call_type }}</td>
            <td>{{ $export->ct_call_type_name }}</td>
            <td>{{ $export->ct_call_type_desc }}</td>
            <td>{{ $export->ct_batch_name }}</td>
            <td>{{ $export->ct_load_date }}</td>
            <td>{{ $export->ct_num_calls }}</td>
            <td>{{ $export->ct_num_recalls }}</td>
            <td>{{ $export->ct_duration }}</td>
            <td>{{ $export->ct_talk_time }}</td>
            <td>{{ $export->ct_comments }}</td>
            <td>{{ $export->ct_phone1 }}</td>
            <td>{{ $export->ct_phone_callback }}</td>
            <td>{{ $export->ct_name }}</td>
            <td>{{ $export->ct_surname }}</td>
            <td>{{ $export->ct_cust1_text01 }}</td>
        </tr>
    @endforeach
 </table>

</html>

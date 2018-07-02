@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="card card-default">
            <div class="card-header">
                <h3>Passage</h3>
            </div>

            <table class="table">
                <thead>
                    <th>Easycode</th>
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
                    <th>Text2</th>
                </thead>

                <tbody>
                    @foreach($Cards as $card)
                        <tr>
                            <td>{{ $card->easycode }}</td>
                            <td>{{ $card->termination_status }}</td>
                            <td>{{ $card->ct_agent }}</td>
                            <td>{{ $card->ct_contact_date }}</td>
                            <td>{{ $card->ct_call_type_id }}</td>
                            <td>{{ $card->ct_call_type }}</td>
                            <td>{{ $card->ct_call_type_name }}</td>
                            <td>{{ $card->ct_call_type_desc }}</td>
                            <td>{{ $card->ct_batch_name }}</td>
                            <td>{{ $card->ct_load_date }}</td>
                            <td>{{ $card->ct_num_calls }}</td>
                            <td>{{ $card->ct_num_recalls }}</td>
                            <td>{{ $card->ct_duration }}</td>
                            <td>{{ $card->ct_talk_time }}</td>
                            <td>{{ $card->ct_comments }}</td>
                            <td>{{ $card->ct_phone1 }}</td>
                            <td>{{ $card->ct_phone_callback }}</td>
                            <td>{{ $card->ct_name }}</td>
                            <td>{{ $card->ct_surname }}</td>
                            <td>{{ $card->ct_cust1_text01 }}</td>
                            <td>{{ $card->ct_cust1_text02 }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
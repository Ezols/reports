@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        
            <div class="card card-default">
                <div class="card-header">
                   <h3>Latvenergo OB2</h3>
                </div>                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Easy code</th>
                            <th>Agent</th>
                            <th>Contact date</th>
                            <th>Calls</th>
                            <th>Recalls</th>
                            <th>Duration</th>
                            <th>Talk time</th>
                            <th>Number</th>
                            <th>Callback</th>
                            <th>Call type</th>
                            <th>Call type name</th>
                            <th>Call tpye desc</th>
                            <th>Call type id</th>
                            <th>Load date</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($Cards as $card)
                            <tr>
                                <td>{{ $card->easycode }}</td>
                                <td>{{ $card->ct_agent }}</td>
                                <td>{{ $card->ct_contact_date }}</td>
                                <td>{{ $card->ct_num_calls }}</td>
                                <td>{{ $card->ct_num_recalls }}</td>
                                <td>{{ $card->ct_duration }}</td>
                                <td>{{ $card->ct_talk_time }}</td>
                                <td>{{ $card->ct_phone1 }}</td>
                                <td>{{ $card->ct_call_type }}</td>
                                <td>{{ $card->ct_phone_callback }}</td>
                                <td>{{ $card->ct_call_type_name }}</td>
                                <td>{{ $card->ct_call_type_desc }}</td>
                                <td>{{ $card->ct_call_type_id }}</td>
                                <td>{{ $card->ct_load_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>                   
                </table>               
            </div>
        
    </div>
</div>
@endsection
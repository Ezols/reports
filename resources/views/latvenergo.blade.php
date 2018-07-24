@extends('layouts.app')

@section('content')
<div class="container-fuild">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3>Latvenergo 1</h3>
                </div>

                <table class="table">
                    <thead>
                        <th>Easycode</th>
                        <th>Date / Time</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </thead>

                    <tbody>
                        @foreach($leob1 as $card)
                        <tr>
                            <td>{{ $card->easycode }}</td>
                            <td>{{ $card->ct_load_date }}</td>
                            <td>{{ $card->ct_MN_ID_message }}</td>
                            <td>{{ $card->ct_call_type_desc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3>Latvenergo 2</h3>
                </div>

                <table class="table">
                        <thead>
                            <th>Easycode</th>
                            <th>Date / Time</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </thead>
    
                        <tbody>
                            @foreach($leob2 as $card)
                            <tr>
                                <td>{{ $card->easycode }}</td>
                                <td>{{ $card->ct_load_date }}</td>
                                <td>{{ $card->ct_MN_ID_message }}</td>
                                <td>{{ $card->ct_call_type_desc }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>   
</div>
@endsection
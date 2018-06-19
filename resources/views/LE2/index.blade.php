<table>
    <tr>
        <th>1</th>
        <th>2</th>
    </tr>
    
    @foreach($Cards as $card)
    <tr>
        
        <td>{{ $card->ct_agent }}</td>
    </tr>
    @endforeach
</table>
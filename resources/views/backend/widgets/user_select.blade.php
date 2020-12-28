@foreach ($datas as $data)
    <option value="{{$data->id}}"
    @if ($data->id==$selected)
        selected
    @endif
    >{{$data->name}}</option>
@endforeach

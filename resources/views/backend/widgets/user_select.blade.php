@foreach ($datas as $data)
    <option value="{{$data->id}}"
    @if ($data->selected)
        selected
    @endif
    >{{$data->name}}</option>
@endforeach

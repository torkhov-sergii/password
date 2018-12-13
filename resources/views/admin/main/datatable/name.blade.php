@if(count($item->children))
    <a href="{{ route('admin.main.index', ['selected_category'=>$item->id]) }}">{{ $item->name }}</a>
@else
    {{ $item->name }}
@endif
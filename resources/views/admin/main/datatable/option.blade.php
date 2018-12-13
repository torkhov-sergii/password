{{--//if ($items->type->isSub) $option .= '<a href="'.route('admin.main.create', [$items->id,$items->type->id]).'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Add sub '.$items->type->name.'</a>';--}}
{{--//if($doctor->user_id) $option .= '<a href="'.route('user.login_as', $doctor->user_id).'" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-new-window"></i> Login as user</a>';--}}

@if($item->type->isSort || (Auth::user()->hasRole('superadmin')))
    <span style="display: inline-block; margin-right: 10px;">
        <a href="{{ route('main.sort', [$item->id, 'up']) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs"><i class="fa fa-arrow-up"></i></a>
        <a href="{{ route('main.sort', [$item->id, 'down']) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs"><i class="fa fa-arrow-down"></i></a>
    </span>
@endif

@if($item->type)
    @foreach($item->type->children()->get() as $type)
        @if($type['isAdd'])
            <a class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ url('admin/main/create/'.$item['id'].'/'.$type['id']) }}"><i class="la la-plus"></i> {{ trans('admin.main.add-new') }} ({{ $type['name'] }})</a>&nbsp;
        @endif
    @endforeach
@endif

{{--@if(count($item->relate))--}}
    {{--<a href="{{ route('main.posts-in-category', $item->id) }}" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i> relations</a>--}}
{{--@endif--}}

@if($item->type->isEdit)
    <a href="{{ route('admin.main.edit', [$item->id, 'selected_category'=>$item->id]) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs"><i class="fa fa-pencil"></i> {{ trans('admin.base.edit') }}</a>
@endif

@if($item->type->isDel)
{{--    <form action="{{ route('admin.main.destroy', [$item->id, 'selected_category'=>$category_id]) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger btn-xs" type="submit"><i class="glyphicon glyphicon-trash"></i> {{ trans('admin.base.delete') }}</button></form>--}}
    <form action="{{ route('admin.main.destroy', [$item->id]) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE">{{ csrf_field() }} <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
@endif
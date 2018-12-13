<tr>
    <td>
        {{ $type['id'] }}
    </td>
    <td class="bold" style="padding-left: {{ ($type['depth']-0.5)*20 }}px">
        @if($type['icon'])
            <i class="{{ $type['icon'] }}"></i>
        @endif
        {{ $type['name'] }}
    </td>
    <td class="text-center">
        @if($type['isAdd']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-center">
        @if($type['isEdit']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-center">
        @if($type['isDel']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-center">
        @if($type['isSeo']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-center">
        @if($type['isSort']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-center">
        @if($type['isShowInMenu']) <i class="fa fa-check m--font-primary"></i> @endif
    </td>
    <td class="text-right">
        {{--<a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('admin.type.show', $type->id) }}">View</a>--}}
        <a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs " href="{{ route('admin.type.edit', $type->id) }}"><i class="fa fa-pencil"></i> {{ trans('admin.base.edit') }}</a>&nbsp;
        <form action="{{ route('admin.type.destroy', $type->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
    </td>
</tr>

@if (count($type['children']) > 0)
    @foreach($type['children'] as $type)
        @include('admin.type.block.each_types', $type)
    @endforeach
@endif
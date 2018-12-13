
<div class="checkbox">
    {{--<label>--}}
    {{--{!! Form::checkbox('relate', false, $main->isRelateWithId($relate->id), array('class' => 'relate_checkbox', 'data-id1' => $relate['id'], 'data-id2' => $main->id)) !!} {{ $relate['name'] }}--}}
    {{--</label>--}}

    @if(isset($relate_list[$relate->type_id]))
        <label class="m-checkbox">
                {!! Form::checkbox('relate', false, $main->isRelateWithId($relate->id), array('class' => 'relate_checkbox', 'data-id1' => $relate['id'], 'data-id2' => $main->id)) !!}
                {{ $relate['name'] }}
                <span></span>
        </label>
        <sup>
        <a href="{{ route('admin.main.edit', $relate->id) }}"><i style="font-size: 0.9rem; margin-left: 3px;" class="fa fa-external-link"></i></a>
        </sup>
    @else
        <label>
            {{ $relate['name'] }}
        </label>
    @endif
</div>

<div style="margin-left: 30px;">
    @if (count($relate['children']) > 0)
        @foreach($relate->children_with_trans as $relate)
            @include('admin.main.block.each_relates', $relate)
        @endforeach
    @endif
</div>



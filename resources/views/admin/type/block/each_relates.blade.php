<div class="checkbox" style="padding-left: {{ ($relate['depth']-1)*20 }}px">
    <label>
        {!! Form::checkbox('relate_with[]', $relate->id, $relate->isRelatewithId($item_id)) !!} {{ $relate->name }}
    </label>
</div>

@if (count($relate['children']) > 0)
    @foreach($relate['children'] as $relates)
        @include('admin.type.block.each_relates', ['relate' => $relates, 'item_id' => $item_id])
    @endforeach
@endif
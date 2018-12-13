<option value="{{ $relate->id }}" @if($parent_id == $relate->id) selected @endif>
    @if($relate['depth'] == 0) @endif
    @if($relate['depth'] == 1) - @endif
    @if($relate['depth'] == 2) -- @endif
    @if($relate['depth'] == 3) --- @endif
    @if($relate['depth'] == 4) ---- @endif
    @if($relate['depth'] == 5) ----- @endif

    {{ $relate->name }}
</option>

@if (count($relate['children']) > 0)
    @foreach($relate['children'] as $relates)
        @include('admin.type.block.each_parents', ['relate' => $relates, 'parent_id' => $parent_id])
    @endforeach
@endif
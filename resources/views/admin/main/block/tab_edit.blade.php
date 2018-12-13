@if(count($main->getFieldsArray()) > 0)
    <div role="tab_edit" class="tab-pane" id="tab_edit">

        @foreach($main->getFieldsArray() as $field)
            @include('admin.main.block.fields')
        @endforeach

        {{--@if(isset($relate_list))--}}
            {{--<div class="form-group">--}}
                {{--<label class="control-label">Relate</label>--}}
                {{--<div class="block_callout_bg">--}}
                    {{--<div class="bs-callout bs-callout-info" style="max-height: 300px; overflow: auto">--}}
                        {{--@foreach($relate_list as $key => $relates)--}}
                            {{--<h5>Relate with: {{ $types[$key]['name'] }}</h5>--}}
                            {{--@foreach ($relates as $relate)--}}
                                {{--@include('admin.main.block.each_relates', $relate)--}}
                            {{--@endforeach--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endif--}}
    </div>
@endif
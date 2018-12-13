{{--@if($item->files)--}}
    {{--<div class="body__file">--}}
        {{--@foreach($item->files as $file)--}}
            {{--<a class="button" href="{{ $file->getUrl() }}" target="_blank">--}}
                {{--<i class="fas fa-download"></i> {{ trans('messages.button.download') }}--}}
            {{--</a>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--@endif--}}
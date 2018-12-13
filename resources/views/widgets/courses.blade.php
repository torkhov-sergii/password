<div class="block-courses">

    @if($type == 'course_item')
        <div class="block-courses__small-title">
            {{ trans('messages.courses.title-also') }}
        </div>
    @else
        <div class="block-courses__title">{{ trans('messages.courses.title') }}</div>
        <div class="block-courses__description">
            {{ trans('messages.courses.description') }}
        </div>
    @endif

    <div class="block-courses__courses-grid owl-carousel">

        @foreach($items as $item)
            <a href="{{ route('courses.view', $item->slug) }}" class="block-course">
                <div class="block-course__image">
                    <img src="{{ $item->previewCache(['w'=>200, 'h'=>150, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']) }}">
                </div>
                <div class="block-course__title">{{ $item->name }}</div>
                <div class="block-course__for">
                    @if($item->select1)
                        {{ Helpers::courses_for_whom_options($item->select1) }}
                    @endif
                </div>
                <div class="block-course__text">{{ $item->text2 }}</div>
                <div class="block-course__length"> {{ trans('messages.courses.length-short') }}: <span>{{ $item->string2 }}</span></div>
            </a>
        @endforeach

    </div>

    <div class="button-container center">
        <a href="{{ route('courses') }}" class="block-courses__expand-button button button_green">{{ trans('messages.courses.all') }}</a>
    </div>
</div>
@extends('admin.layout')

@section('content')

    <div class="p-main">
        <div class="row">
            {{--<div class="col-md-3">--}}
                {{--<div class="list-group">--}}
                    {{--@each('admin.main.block.category_list', $categories, 'category')--}}
                {{--</div>--}}

                {{--@foreach($categories as $category)--}}
                    {{--<div class="list-group">--}}
                        {{--@if($category->getIsOnlyEdit())--}}
                            {{--<a class="list-group-item @if($category->id == Session::get('selected_category')) active @endif" href="{{ route('admin.main.edit', [$category->id, 'selected_category'=>$category->id]) }}" style="padding-left: {{ ($category['depth']-0.5)*20 }}px">--}}
                                {{--{{$category->name}}--}}
                            {{--</a>--}}
                        {{--@else--}}
                            {{--<a href="{{ route('admin.main.index', ['selected_category'=>$category->id]) }}" class="list-group-item @if($category->id == Session::get('selected_category')) active @endif" style="padding-left: {{ ($category['depth']-0.5)*20 }}px">--}}
                                {{--{{$category->name}} <i class="glyphicon glyphicon-chevron-down c999"></i>--}}
                            {{--</a>--}}
                        {{--@endif--}}

                        {{--@each('admin.main.block.category_list', $category['children'], 'category')--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}

            <div class="col-md-12">
                @yield('main_content')
            </div>
        </div>
    </div>

@stop

@extends('admin.layout')

@section('page_title', trans('admin.main.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-pencil"></i> {{ $main->type->name }}
    </div>

    <div class="m-portlet__head-tools">
        {{--@if($main->type->isSub)--}}
            {{--<a href="{{ route('admin.main.create', [$main->id,$main->type->id]) }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air"><i class="la la-plus"></i> Add sub ({{ $main->type->name }})</a>--}}
        {{--@endif--}}

        @if($main->type)
            @foreach($main->type->children()->get() as $type)
                @if($type['isAdd'])
                    <a class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" href="{{ url('admin/main/create/'.$main['id'].'/'.$type['id']) }}"><i class="la la-plus"></i> {{ trans('admin.main.add-new') }} ({{ $type['name'] }})</a>&nbsp;
                @endif
            @endforeach
        @endif

        {{--мешает основной форме + редирект бек выдает ошибку, просто убираю--}}
        {{--@if($main->type->isDel)--}}
            {{--<form action="{{ route('admin.main.destroy', $main->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>--}}
        {{--@endif--}}
    </div>
@stop

@section('content_empty')
    {!! Form::open(array('url' => route('admin.main.update', $main->id), 'method' => 'post', 'role' => 'form', 'class' => 'form-vertical', 'files' => true)) !!}
    <div class="p-main row">
        <div class="col-md-9">
            <div class="m-portlet">
                @if($__env->yieldContent('page_subtitle'))
                    <div class="m-portlet__head">
                        @yield('page_subtitle')
                    </div>
                    @if($main->getUrl())
                        <div class="m-portlet__url">
                            <a href="{{ $main->getUrl() }}" target="_blank"><i class="m-menu__link-icon fa fa-external-link"></i> {{ env('APP_URL').$main->getUrl() }}</a>
                        </div>
                    @endif
                @endif

                <div class="m-portlet__body">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="id_for_trumbowyg_upload" value="{{ $main->id }}">

                    @if(count($main->getFieldsArray()) > 0 || $main->type['isSeo'])
                        <div class="tabbable-custom">
                            <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--primary" role="tablist">
                                @if(count($main->getFieldsArray()) > 0)
                                    <li class="nav-item m-tabs__item"><a href="#tab_edit" class="nav-link m-tabs__link active" aria-controls="tab_edit" role="tab" data-toggle="tab"><i class="fa fa-pencil"></i>{{ trans('admin.main.tab-edit') }}</a></li>
                                @endif
                                @if($main->type['isSeo'])
                                    <li class="nav-item m-tabs__item"><a href="#tab_seo" class="nav-link m-tabs__link" aria-controls="tab_seo" role="tab" data-toggle="tab"><i class="flaticon-line-graph"></i>{{ trans('admin.main.tab-seo') }}</a></li>
                                @endif
                                @permission('type')
                                <li class="nav-item m-tabs__item"><a href="#admin" class="nav-link m-tabs__link" aria-controls="admin" role="tab" data-toggle="tab"><i class="fa fa-cog"></i>SuperAdmin</a></li>
                                @endpermission
                            </ul>

                            <div class="tab-content">
                                @include('admin.main.block.tab_edit')

                                @include('admin.main.block.tab_seo')

                                @include('admin.main.block.tab_admin')
                            </div>
                        </div>

                        <div class="m-form__actions">
                            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.save') }}</button>
                            <a class="btn btn-link pull-right" href="{{ route('admin.main.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
                        </div>
                    @else
                        <h3 class="text-center alert alert-info" style="margin-top: 0px">{{ trans('admin.main.nothing-edit') }}</h3>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('admin.main.block.aside')
        </div>
    </div>
    {!! Form::close() !!}
@endsection
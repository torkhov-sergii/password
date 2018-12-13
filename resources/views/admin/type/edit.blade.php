@extends('admin.layout')

@section('page_title', 'Type')

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-pencil"></i> Type / Edit
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.type.update', $type->id), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
        <input type="hidden" name="_method" value="PUT">

        {{--{!! Form::hidden('title', $type->title == '' ? '': $type->title) !!}  --}}{{--для принудительного создания записи в type_translations --}}
        {{--{!! Form::text('title', $type->title == '' ? '[name]': $type->title) !!} --}}{{-- для принудительного создания записи в type_translations --}}
        {{--{!! Form::text('description', $type->description == '' ? '[global_description]': $type->description) !!} --}}{{-- для принудительного создания записи в type_translations --}}
        {{--{!! Form::text('keywords', $type->keywords == '' ? '[global_keywords]': $type->keywords) !!} --}}{{-- для принудительного создания записи в type_translations --}}

        <div class="form-body">
            <div class="form-group">
                <label for="name" class="control-label col-md-2">Parent type</label>

                <div class="col-md-7">
                    <select id="select_parent" name="parent" class="form-control" data-parent_id="{{ $type->parent_id }}">
                        <option value="1" class="bold">Root</option>
                        {{--@each('admin.type.block.item_option_list', $types, 'type')--}}

                        @foreach($types as $relates)
                            @include('admin.type.block.each_parents', ['relate' => $relates, 'parent_id' => $type->parent_id])
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">{{ trans('admin.base.name') }}</label>

                <div class="col-md-7">
                    {!! Form::text('name', $type->name, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Route name</label>

                <div class="col-md-7">
                    {!! Form::text('route', $type->route, array('class' => 'form-control')) !!}
                    <div style="font-size:13px;">for creation URL (search, sitemap, etc.). В роуте должен фигурировать "slug" ('url' => ['blog', 'parenttype=11=slug', 'slug'])</div>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Menu</label>

                <div class="col-md-7">
                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isShowInMenu" value="0">
                            {!! Form::checkbox('isShowInMenu', 1, $type['isShowInMenu']) !!} Show in menu
                            <span></span>
                        </label>
                    </div>

                    <div class="">Icon in menu</div>
                    {!! Form::text('icon', $type->icon, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Parameters</label>

                <div class="col-md-7">
                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isSeo" value="0">
                            {!! Form::checkbox('isSeo', 1, $type['isSeo']) !!} Seo field
                            <span></span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isAdd" value="0">
                            {!! Form::checkbox('isAdd', 1, $type['isAdd']) !!} Add item
                            <span></span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isEdit" value="0">
                            {!! Form::checkbox('isEdit', 1, $type->isEdit) !!} Edit item
                            <span></span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isDel" value="0">
                            {!! Form::checkbox('isDel', 1, $type->isDel) !!} Del item
                            <span></span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isSort" value="0">
                            {!! Form::checkbox('isSort', 1, $type->isSort) !!} Sort item
                            <span></span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label class="m-checkbox">
                            <input type="hidden" name="isSub" value="0">
                            {!! Form::checkbox('isSub', 1, $type->isSub) !!} Возможность добавления неограниченной вложенности с тем же типом
                            <span></span>
                        </label>
                    </div>

                    <div style="font-size:13px;">(относится конкретно к этому элементу, а не детям)</div>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Fields</label>

                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::textarea('fields', $type->fields, array('class' => 'form-control', 'style' => 'height: 400px')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::textarea('fields_aside', $type->fields_aside, array('class' => 'form-control', 'style' => 'height: 400px')) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="jumbotron" style="padding: 10px; margin-bottom: 0px; font-size: 12px;">
                                name text text1 text2 text3 string1 string2 string3 string4 string5 bool1 bool2 bool3 bool4 bool5 select1 select2 date date2
                                <br>
                                <br>Name->name
                                <br>Text->text->{"panel":true}
                                <br>Small tex2->text2
                                <br>String->string1->{"copy":true}
                                <br>String2->string2
                                <br>Date->date
                                <br>Date2->date2
                                <br>Date->created_at
                                <br>Checkbox->bool1
                                <br>Option->select1->{"1":"kiev","2":"lvov"}
                                <br>Images->images
                                <br>Preview horisontal->preview->{"ratio":"200:100","type":""}
                                <br>Preview vertical->preview->{"ratio":"100:200","type":""}
                                <br>Images multiple->img_multiple (не работает)
                                <br>Files->files
                                <br>Location->location
                                <br>Tags->tags
                                <br>Author->author
                                <br>Типы статей->relates->{"type_id":"20","table":"main"}
                                <br>Категория чего либо->relates->{"parent_id":"51","table":"main"}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--@if (count($types) > 0)--}}
                {{--<div class="form-group">--}}
                    {{--<label class="control-label col-md-2">Relate with:</label>--}}
                    {{--<div class="block_callout_bg  col-md-7">--}}
                        {{--<div class="bs-callout bs-callout-info">--}}
                            {{--@foreach($types as $relates)--}}
                                {{--@include('admin.type.block.each_relates', ['relate' => $relates, 'item_id' => $type->id])--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}

            <div class="m-form__actions">
                <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.save') }}</button>
                <a class="btn btn-link pull-right" href="{{ route('admin.type.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
@extends('admin.layout')

@section('page_title', 'Type')

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="la la-plus"></i>
        Type / Create
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.type.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}

    <div class="form-body">
        <div class="form-group">
            <label for="name" class="control-label col-md-2">Parent type</label>

            <div class="col-md-7">
                <select name="parent" class="form-control">
                    <option value="0" class="bold">Root</option>
                    {{--@each('admin.type.block.each_parents', $types, 'relate')--}}

                    @foreach($types as $relates)
                        @include('admin.type.block.each_parents', ['relate' => $relates, 'parent_id' => 0])
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="control-label col-md-2">{{ trans('admin.base.name') }}</label>

            <div class="col-md-5">
                {!! Form::text('name', '', array('class' => 'form-control')) !!}
            </div>
        </div>

        {{--<div class="form-group">--}}
            {{--<label for="name" class="control-label col-md-2">Category</label>--}}

            {{--<div class="col-md-7">--}}
                {{--<div class="checkbox">--}}
                    {{--<input type="hidden" name="isCategory" value="0">--}}
                    {{--<label>{!! Form::checkbox('isCategory', 1, false) !!} This is category/item - add to main (например blog это категория, а post нет и записи post не должно быть в main)     </label>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.create') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.type.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
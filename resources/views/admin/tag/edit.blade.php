@extends('admin.layout')

@section('page_title', trans('admin.tag.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-pencil"></i> {{ trans('admin.tag.title-edit') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.tag.update', $tag->id), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
        <input type="hidden" name="_method" value="PUT">

        <div class="form-body">

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Tag</label>
                <div class="col-md-7">
                    {!! Form::text('name', $tag->name, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">Slug</label>
                <div class="col-md-7">
                    {!! Form::text('slug', $tag->slug, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">{{ trans('admin.tag.used') }}</label>
                <div class="col-md-7">
                    @foreach($tag->post as $post)
                        <div>
                            <a href="{{ route('admin.main.edit', $post->id) }}">{{ $post->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.save') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.tag.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
        </div>
    {!! Form::close() !!}
@endsection
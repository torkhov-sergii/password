@extends('admin.layout')

@section('page_title', trans('admin.role.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-pencil"></i> {{ trans('admin.role.title-edit') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.role.update', $role->id), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
        <input type="hidden" name="_method" value="PUT">

        <div class="form-body">
            <div class="form-group">
                <label for="name" class="control-label col-md-2">{{ trans('admin.base.title') }}</label>
                <div class="col-md-7">
                    {!! Form::text('name', $role->name, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">{{ trans('admin.base.description') }}</label>
                <div class="col-md-7">
                    {!! Form::textarea('description', $role->description, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-2">{{ trans('admin.role.allow_categories') }}</label>
                <div class="col-md-7">
                    {!! Form::text('allow_categories', $role->allow_categories, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">{{ trans('admin.role.permissions') }}</label>
                <div class="col-md-7">
                    <div class="block_callout_bg">
                        <div class="bs-callout bs-callout-info">
                            @foreach($permissions as $permission)
                                <div class="checkbox">
                                    <label class="m-checkbox">
                                        {{--{{ dd($role->permissions()->get()->lists('id')->all()) }}--}}
                                        {!! Form::checkbox('permissions['.$permission->id.']', $permission->id,
                                            in_array($permission->id, $role->permissions()->get()->pluck('id')->all())
                                        )!!}
                                        <b>{{ $permission->name }}</b> ({{ $permission->description }})
                                        <span></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.save') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.role.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
        </div>
    {!! Form::close() !!}
@endsection
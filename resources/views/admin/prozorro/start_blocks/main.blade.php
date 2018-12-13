@extends('admin.prozorro.layout')

@section('page_title', 'Блоки популярних статей')

@section('main_content')
    {!! Form::open(array('url' => '/admin/prozorro/start-blocks', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => false)) !!}
    <style>
        .number_column {
            max-width: 50px;
        }
        .number {
            padding: 5px 0 0 0; font-size: 15px; font-weight: bold;
        }
    </style>

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <i class="glyphicon glyphicon-folder-open"></i> Замовнику
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1 number_column">
                        <div class="form-group">
                            <label for="name" class="control-label">#</label>
                            <div class="number">TOP</div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Заголовок</label>
                            {!! Form::text('customer[first][title]', $customer['first']['title'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Посилання</label>
                            {!! Form::text('customer[first][url]', $customer['first']['url'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                @for ($i = 1; $i < 6; $i++)
                    <div class="row">
                        <div class="col-md-1 number_column">
                            <div class="form-group">
                                <div class="number">{{ $i }}.</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::text('customer[list]['.$i.'][title]', $customer['list'][$i]['title'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::text('customer[list]['.$i.'][url]', $customer['list'][$i]['url'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                @endfor

                <div class="m-form__actions">
                    <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <i class="glyphicon glyphicon-folder-open"></i> Учаснику
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1 number_column">
                        <div class="form-group">
                            <label for="name" class="control-label">#</label>
                            <div class="number">TOP</div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Заголовок</label>
                            {!! Form::text('participant[first][title]', $participant['first']['title'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Посилання</label>
                            {!! Form::text('participant[first][url]', $participant['first']['url'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                @for ($i = 1; $i < 6; $i++)
                    <div class="row">
                        <div class="col-md-1 number_column">
                            <div class="form-group">
                                <div class="number">{{ $i }}.</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::text('participant[list]['.$i.'][title]', $participant['list'][$i]['title'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::text('participant[list]['.$i.'][url]', $participant['list'][$i]['url'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                @endfor

                <div class="m-form__actions">
                    <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <i class="glyphicon glyphicon-folder-open"></i> Для журналістів та громадськості
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1 number_column">
                        <div class="form-group">
                            <label for="name" class="control-label">#</label>
                            <div class="number">TOP</div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Заголовок</label>
                            {!! Form::text('press[first][title]', $press['first']['title'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Посилання</label>
                            {!! Form::text('press[first][url]', $press['first']['url'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                @for ($i = 1; $i < 6; $i++)
                    <div class="row">
                        <div class="col-md-1 number_column">
                            <div class="form-group">
                                <div class="number">{{ $i }}.</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::text('press[list]['.$i.'][title]', $press['list'][$i]['title'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::text('press[list]['.$i.'][url]', $press['list'][$i]['url'], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                @endfor

                <div class="m-form__actions">
                    <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop

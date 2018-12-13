@extends('admin.layout')

@section('page_title', trans('admin.translation.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-globe"></i> {{ trans('admin.translation.title-list') }}
    </div>
@stop

@section('content')
    <div class="p-translations">
        @if(count($groups)>1)
            <form role="form">
                <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                <div class="form-group">
                    <select name="group" id="group" class="form-control group-select">
                        <option data-url="{{ route('admin.translations') }}" value="">{{ trans('admin.translation.choose-group') }}</option>
                        @foreach($groups as $key => $value)
                            <option data-url="{{ route('admin.translations.view', [$key]) }}" value="{{ $key }}" @if($key == $group) selected @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif

        @if($group)
            @role('superadmin')
            <div class="add_new_keys">
                {!! Form::open(array('url' => route('admin.translations.add', [$group]), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <input class="form-control" rows="3" name="keys" placeholder="Add 1 key per line, without the group prefix">
                            </div>
                            <div class="col-md-5">
                                <input class="form-control" rows="3" name="value" placeholder="Value">
                            </div>
                            <div class="col-md-2">
                                <input type="submit" value="Add keys" class="btn btn-success w-100">
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            @endrole

            <div>
                @if(isset($group))
                    <div class="m-form__actions" style="border-bottom: 1px solid #ebedf2; padding-bottom: 25px; margin-bottom: 30px; margin-top: 0">
                        {!! Form::open(array('url' => route('admin.translations.publish', [$group]), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
                            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" data-disable-with="Publishing.." >{{ trans('admin.translation.save') }}</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Key</th>
                    @foreach($locales as $locale)
                        <th>{{ $locale }}</th>
                    @endforeach
                    @role('superadmin')
                        <th class="text-right">{{ trans('admin.base.option') }}</th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                    @foreach($translations as $key => $translation)
                        <tr id="{{ $key }}">
                            <td>{{ $key }}</td>
                            @foreach($locales as $locale)
                                <?php $t = isset($translation[$locale]) ? $translation[$locale] : null ?>
                                <td>
                                    <span class="js__string" data-toggle="modal" data-target="#translation_modal" data-key="{{ $key }}" data-locale="{{ $locale }}" data-id="{{ $t['id'] }}" data-group="{{ $group }}" data-value="{{ $t['value'] }}">
                                        @if($t['value'])
                                            {{ $t['value'] }}
                                        @else
                                            {{ trans('admin.translation.empty') }}
                                        @endif
                                    </span>
                                </td>
                            @endforeach
                            @role('superadmin')
                                <td class="text-right">
                                    <form action="{{ route('admin.translations.delete', [$group, $key]) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
                                </td>
                            @endrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                @if(isset($group))
                    <div class="m-form__actions" style="border-bottom: 1px solid #ebedf2; padding-bottom: 25px; margin-bottom: 30px;">
                        {!! Form::open(array('url' => route('admin.translations.publish', [$group]), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
                        <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" data-disable-with="Publishing.." >{{ trans('admin.translation.save') }}</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        @else
            <p>Choose a group to display the group translations. If no groups are visisble, make sure you have run the migrations and imported the translations.</p>
        @endif

        <div class="modal fade show" id="translation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ trans('admin.translation.title') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    {{ trans('admin.translation.translate') }}
                                </label>
                                <textarea class="form-control js__value" style="height: 200px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary js__close" data-dismiss="modal">
                            {{ trans('admin.base.close') }}
                        </button>
                        <button type="button" class="btn btn-primary js__save">
                            {{ trans('admin.base.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <i class="fa fa-gear"></i> {{ trans('admin.settings.title') }}
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="form-group">
            <label class="control-label">{{ trans('admin.base.status') }}</label>

            <div class="input-group">
                @if(!$main->hide) <div class="input-group-addon"><i class="fa fa-check m--font-success"></i></div> @endif
                @if($main->hide) <div class="input-group-addon"><i class="fa fa-close m--font-danger"></i></div> @endif
                {!! Form::select('hide', [0=>trans('admin.main.published'), 1=>trans('admin.main.draft')], $main->hide, array('class' => 'form-control ')) !!}
            </div>
        </div>

        @foreach($main->getFieldsArray('fields_aside') as $field)
            @include('admin.main.block.fields')
        @endforeach
    </div>
</div>
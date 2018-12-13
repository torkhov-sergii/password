@if(strpos($field['type'], 'name') !== false)
    <div class="form-group">
        <label for="name" class="control-label">{{ $field['name'] }}</label>
        {!! Form::text($field['type'], $main[$field['type']], array('class' => 'form-control')) !!}
    </div>
@endif

@if(strpos($field['type'], 'text') !== false)
    <div class="form-group wysiwyg__container">
        <label for="{{$field['type']}}" class="control-label" title="{{ $field['type'] }}">{{ $field['name'] }}</label>
        @if(isset($field['param']['panel']))
            {!! Form::textarea($field['type'], $main[$field['type']], array('class' => 'form-control input_wysiwyg', 'id'=>'editor1')) !!}
        @else
            {!! Form::textarea($field['type'], $main[$field['type']], array('class' => 'form-control')) !!}
        @endif
    </div>
@endif

@if(strpos($field['type'], 'date') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label" title="{{ $field['type'] }}">{{ $field['name'] }}</label>

        <div class="input-group">
            <div class="input-group-addon"><i class="la la-calendar"></i></div>
            {!! Form::text($field['type'], (!empty($main[$field['type']]) ? \Carbon\Carbon::parse($main[$field['type']])->toDateString() : date('Y-m-d')), array('class' => 'form_date form-control', 'id'=>'inputPublishedAt')) !!}
        </div>
    </div>
@endif

@if(strpos($field['type'], 'string') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label" title="{{ $field['type'] }}">{{$field['name']}}</label>
        {!! Form::text($field['type'], $main[$field['type']], array('class' => 'form-control')) !!}
    </div>
@endif

@if(strpos($field['type'], 'bool') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label">{{$field['name']}}</label>
        <div>
            <label class="m-checkbox">
                <input type="hidden" name="{{$field['type']}}" value="0">
                {!! Form::checkbox($field['type'], 1, $main[$field['type']]) !!} {{$field['name']}}
                <span></span>
            </label>
        </div>
    </div>
@endif

@if(strpos($field['type'], 'select') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label">{{$field['name']}}</label>
        {!! Form::select($field['type'], $field['param'], $main[$field['type']], array('class' => 'form-control')) !!}
    </div>
@endif

@if(strpos($field['type'], 'images') !== false || strpos($field['type'], 'img_multiple') !== false)
    <div class="form-group">
        <label class="control-label">{{ $field['name'] }}</label>

        <div class="block_callout_bg">
            <div class="bs-callout bs-callout-info">
                @if(strpos($field['type'], 'images') !== false)
                    <div class="b-add-more-images" data-name="images" data-type="{{ $field['param']['type'] }}">
                        <div id="input_fields_wrap">
                        </div>
                        <button type="button" id="add_field_button" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs">{{ trans('admin.main.image-add-more') }}</button>
                    </div>
                @endif

                @if(strpos($field['type'], 'img_multiple') !== false)
                    <div>
                        @include('vendor.fileuploader.multiple', ['img' => $main->previewCache(['w'=>100, 'h'=>100, 'scale'=>'min', 'type'=>'']), 'object' => 'main', 'object_id' => $main['id']])
                        {{--@include('vendor.fileuploader.multiple', ['img' => $main->preview->getCache(['w'=>100, 'h'=>100, 'scale'=>'min']), 'object' => 'main', 'object_id' => $main['id']])--}}
                    </div>
                @endif

                @if(count($main->images($field['param']['type'])->get()))
                    <div class="b-images">
                        <h5>{{ trans('admin.main.image-list') }}</h5>

                        @foreach($main->images($field['param']['type'])->get() as $image)
                            <div class="image-container">
                                <img src="{{ $image->getCache(['w'=>100, 'h'=>100, 'scale'=>'max', 'type'=>'']) }}">
                                <input type="text" name="alt_{{ $image->id }}" id="alt_{{ $image->id }}" value="{{ $image->getAlt() }}" placeholder="Write alt here..." class="image_alt" style="margin-right: 10px;">
                                <button type="button" class="update_alt_button btn btn-warning btn-xs" data-id="{{ $image->id }}" style="margin-left: 10px;">{{ trans('admin.main.image-update') }}</button>
                                <button type="button" class="remove_button btn btn-danger btn-xs" data-id="{{ $image->id }}">{{ trans('admin.main.image-remove') }}</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

@if(strpos($field['type'], 'files') !== false)

    <div class="form-group">
        <label class="control-label">{{ $field['name'] }}</label>

        <div class="block_callout_bg">
            <div class="bs-callout bs-callout-info">
                <div>
                    <div class="b-add-more-files" data-name="files" data-type="{{ $field['param']['type'] }}">
                        <div id="input_fields_wrap">
                        </div>
                        <button type="button" id="add_field_button" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs">{{ trans('admin.main.files-more') }}</button>
                    </div>
                </div>

                @if(count($main->files($field['param']['type'])->get()))
                    <div class="b-files">
                        <h5>{{ trans('admin.main.files-list') }}</h5>

                        @foreach($main->files($field['param']['type'])->get() as $file)
                            <div class="file-container">
                                <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->file_file_name }}</a>
                                &nbsp;
                                <button type="button" class="remove_button btn btn-danger btn-xs" data-id="{{ $file->id }}">{{ trans('admin.main.files-remove') }}</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

@if(strpos($field['type'], 'location') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label">{{$field['name']}}</label>
        @include('vendor.locations.edit', ['object'=>$main])
    </div>
@endif

@if(strpos($field['type'], 'relates') !== false)
    <div class="form-group">
        <label class="control-label">{{ $field['name'] }}</label>
        <div class="b-select2">
            <select class="js__select2" multiple="multiple" name="relates[]" data-type_id="{{ isset($field['param']['type_id']) ? $field['param']['type_id'] : null }}" data-parent_id="{{ isset($field['param']['parent_id']) ? $field['param']['parent_id']: null }}" data-table="{{ $field['param']['table'] }}">
                <optgroup label="tag" class="bold">
                    @if(isset($field['param']['type_id']))
                        @foreach($main->getRelateByType($field['param']['type_id']) as $tag)
                            <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                        @endforeach
                    @endif

                    @if(isset($field['param']['parent_id']))
                        @foreach($main->getRelateByParent($field['param']['parent_id']) as $tag)
                            <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                        @endforeach
                    @endif

                </optgroup>
            </select>
        </div>
    </div>
@endif

@if(strpos($field['type'], 'tags') !== false)
    <div class="form-group">
        <label class="control-label">{{$field['name']}}</label>
        <div class="b-select2">
            <select class="js__select2" multiple="multiple" name="tags[]" data-table="tags" data-custom="true">
                <optgroup label="tag" class="bold">
                    @foreach($main->tags as $tag)
                        <option value="{{ $tag->name }}" {{ in_array($tag->id, $main->tags()->allRelatedIds()->all()) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>
@endif

@if(strpos($field['type'], 'created_at') !== false)
    <div class="form-group">
        <label for="{{$field['type']}}" class="control-label" title="{{ $field['type'] }}">{{ $field['name'] }}</label>

        <div class="input-group">
            <div class="input-group-addon"><i class="la la-calendar"></i></div>
            {!! Form::text($field['type'], \Carbon\Carbon::parse($main[$field['type']])->toDateString(), array('class' => 'form_date form-control', 'id'=>'inputPublishedAt')) !!}
        </div>
    </div>
@endif

@if(strpos($field['type'], 'author') !== false)
    <div class="form-group">
        <div class="b__author">
            <label for="{{$field['type']}}" class="control-label">
                {{$field['name']}}
                <span class="js__change-author">{{ trans('admin.main.change-author') }}</span>
            </label>

            @if($main->user)
            <div class="author__wrapper">
                <div class="author__image" style="background-image: url('{{ $main->user->previewCache(['w'=>40, 'h'=>40, 'scale'=>'crop', 'type'=>'']) }}')">
                </div>

                <div class="author__name">
                    {{ $main->user['full_name'] }}
                </div>
            </div>
            @endif

            <div class="author__change">
                {!! Form::select('user_id', \App\Models\User::all()->pluck('full_name', 'id'), $main->user['id'], array('class' => 'form-control')) !!}
            </div>
        </div>

    </div>
@endif

@if(strpos($field['type'], 'preview') !== false)
    <div class="form-group">
        <label for="surname" class="control-label">
            {{ $field['name'] }}
        </label>
        <div>
            @include('vendor.fileuploader.crop', ['img' => $main->previewCache(['w'=>300, 'h'=>300, 'scale'=>'min', 'type'=>$field['param']['type'], 'nocache'=>1, 'default'=>'no_image']), 'object' => 'main', 'object_id' => $main['id'], 'aspect_ratio' => $field['param']['ratio'], 'image_type' => $field['param']['type']])
        </div>
        @if($main->preview($field['param']['type'])->first())
            <div class="mt-1 text-center">
                <a class="btn btn-primary btn-xs m-btn--pill m-btn--air" href="{{ $main->previewCache(['w'=>800, 'h'=>600, 'scale'=>'min', 'type'=>$field['param']['type'], 'nocache'=>1, 'default'=>'no_image']) }}" target="_blank">{{ trans('admin.main.download') }}</a>
                <span class="js__remove-image btn btn-danger btn-xs m-btn--pill m-btn--air" data-id="{{ $main->preview($field['param']['type'])->first()->id }}"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</span>
            </div>
        @endif
    </div>
@endif
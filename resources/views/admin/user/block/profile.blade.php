    <div class="form-horizontal form-bordered">
        <div class="form-body">
            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.avatar') }}</label>
                <div class="col-md-8">
                    {{--внутрь формы переносить нелья - будет ошибка--}}
                    @include('vendor.fileuploader.crop', ['img' => $user->previewCache(['w'=>160, 'h'=>160, 'scale'=>'crop', 'type'=>'', 'nocache'=>true, 'default'=>'no_avatar']), 'object' => 'user', 'object_id' => $user['id'], 'aspect_ratio' => '100:100'])
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(array('url' => route('admin.user.update', $user->id), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
        <input type="hidden" name="_method" value="PUT">

        @include('errors.form_request')

        <div class="form-body">
            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.login') }}</label>
                <div class="col-md-3">
                    {!! Form::text('login', $user['login'], array(
                       'placeholder' => trans('admin.user.login'),
                       'class' => 'form-control',
                   )) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.email') }}</label>
                <div class="col-md-3">
                    {!! Form::text('email', $user['email'], array(
                        'placeholder' => trans('admin.user.email'),
                        'class' => 'form-control',
                    )) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.name') }}</label>
                <div class="col-md-3">
                    {!! Form::text('name', $user['name'], array(
                        'placeholder' => trans('admin.user.name'),
                        'class' => 'form-control',
                    )) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.surname') }}</label>
                <div class="col-md-3">
                    {!! Form::text('surname', $user['surname'], array(
                        'placeholder' => trans('admin.user.surname'),
                        'class' => 'form-control',
                    )) !!}
                </div>
            </div>

            <div class="form-group mt-5">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.status') }}</label>
                <div class="col-md-3">
                    {!! Form::select('role', array('default' => 'Please select role') + $roles->toArray(), $user->getRole('id'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="login" class="control-label col-md-2">{{ trans('admin.user.password-new') }}</label>
                <div class="col-md-3">
                    <div class="form-group mb-2 mt-2">
                        <label class="control-label" style="font-size: 11px;">Password</label>
                        {!! Form::password('password', array(
                            'id' => 'input_password',
                            'class' => 'form-control',
                            'data-rule-required' => 'true', 'data-msg-required' => trans('admin.user.password-required'),
                            'data-rule-min' => '6', 'data-msg-min' => trans('admin.user.password-length')
                        )) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label" style="font-size: 11px;">Confirm password</label>
                        {!! Form::password('password_confirmation', array(
                            'class' => 'form-control',
                            'data-rule-required' => 'true', 'data-msg-required' => trans('admin.user.password-confirm'),
                            'data-rule-equalto' => '#input_password', 'data-msg-equalto' => trans('admin.user.password-equalto')
                        )) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.save') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.user.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
        </div>
    {!! Form::close() !!}
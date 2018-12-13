@extends('admin.layout')

@section('page_title', trans('admin.seo.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-heart-empty"></i> {{ trans('admin.seo.title-edit') }}
    </div>
@stop

@section('content_empty')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <i class="glyphicon glyphicon-heart-empty"></i> {{ trans('admin.seo.globals') }}
            </div>
        </div>

        <div class="m-portlet__body">
            {!! Form::open(array('url' => route('admin.seo.update', ''), 'method' => 'post', 'role' => 'form', 'class' => 'form-vertical', 'files' => false)) !!}
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="control-label">{{ trans('admin.seo.site-title') }}</label>
                        {!! Form::text('global_title_' . App::getLocale(), Settings::get('global_title_' . App::getLocale()), array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">{{ trans('admin.seo.site-description') }}</label>
                        {!! Form::text('global_description_' . App::getLocale(), Settings::get('global_description_' . App::getLocale()), array('class' => 'form-control')) !!}
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="control-label">twitter:site</label>
                                {!! Form::text('global_twitter_site_' . App::getLocale(), Settings::get('global_twitter_site_' . App::getLocale()), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="control-label">twitter:creator</label>
                                {!! Form::text('global_twitter_creator_' . App::getLocale(), Settings::get('global_twitter_creator_' . App::getLocale()), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="control-label">og:site_name</label>
                                {!! Form::text('global_og_site_name_' . App::getLocale(), Settings::get('global_og_site_name_' . App::getLocale()), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="control-label">fb:admins</label>
                                {!! Form::text('global_fb_admins_' . App::getLocale(), Settings::get('global_fb_admins_' . App::getLocale()), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-form__actions">
                <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if(env('SITE_SEO_PATTERNS') == true)
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <i class="glyphicon glyphicon-heart-empty"></i> {{ trans('admin.seo.title-patterns') }}
            </div>
        </div>

        <div class="m-portlet__body">
            {!! Form::open(array('url' => route('admin.seo.update', ''), 'method' => 'post', 'role' => 'form', 'class' => 'form-vertical', 'files' => false)) !!}
            <div class="panel panel-primary">
                <div class="panel-body">
                    <label class="control-label">You can use patterns in all fields or add any custom text. You can also set a unique meta-data for each page when editing it.</label>
                    <p>For example, blog post may be - "<b>Blog post: [name]</b>" or "<b>[name] | Blog</b>" etc.</p>
                    <div class="block_callout_bg" style="margin-bottom: 30px;">
                        <div class="bs-callout bs-callout-info">
                            [name] - article/page Name
                            <br>[global_title] - global Title
                            <br>[global_description] - global Description
                            {{--<br>[global_keywords] - global Keywords--}}
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('admin.base.name') }}</th>
                            <th>{{ trans('admin.base.title') }}</th>
                            <th>{{ trans('admin.base.description') }}</th>
                            <th>
                                itemscope itemtype
                                <br><span class="fs12 c666" style="font-weight: normal">http://schema.org/Article/</span>
                            </th>
                            {{--<th>Keywords</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                            @each('admin.seo.block.each_item', $items, 'item')
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="m-form__actions">
                <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @endif

@stop
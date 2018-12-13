@if($main->type['isSeo'])
    <div role="tab_seo" class="tab-pane" id="tab_seo">

        @if($main['slug'] && $main->change_slug)
            <div class="form-group">
                <label for="slug" class="control-label">Slug</label>
                {!! Form::text('slug', $main['slug'], array('class' => 'form-control')) !!}
            </div>
        @endif

        @if(env('SITE_SEO') == 'normal')
            <div class="form-group">
                <label for="title" class="control-label">{{ trans('admin.base.title') }}</label>
                {!! Form::text('title', $main['title'], array('class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <label for="description" class="control-label">{{ trans('admin.base.description') }}</label>
                {!! Form::text('description', $main['description'], array('class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <label for="keywords" class="control-label">{{ trans('admin.seo.keywords') }}</label>
                {!! Form::text('keywords', $main['keywords'], array('class' => 'form-control')) !!}
            </div>
        @else
            <div class="form-group">
                <label for="description" class="control-label">SEO Meta Tags</label>
                {!! Form::textarea('seo_meta_tags', $main['seo_meta_tags'], array('class' => 'form-control', 'style'=>'height:600px;')) !!}
            </div>
        @endif

        <label class="control-label">{{ trans('admin.seo.also-automatically-added') }}</label>
        <div class="block_callout_bg" style="margin-bottom: 30px;">
            <div class="bs-callout bs-callout-info">
                &lt;meta property="article:modified_time" content="{{ date('Y-m-d H:i:s') }}" /&gt;
                @if (isset($seo_alternates))
                    <br>
                    @foreach($seo_alternates as $lang=>$alternate)
                        &lt;link rel="alternate" href="{{ $alternate['url'] }}" hreflang="{{ $alternate['hreflang'] }}" /&gt;<br>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endif
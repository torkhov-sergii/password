<div class="form-group">
    <label class="control-label">Log in using social networks</label>

    <div style="padding-top: 10px;">
        @foreach(\App\Models\User::$social_profile as $key => $profile)
            <a href="{{ url('/social/'.$key.'/login') }}" class="btn btn-social-icon btn-{{ $profile['bootstrap'] }}">
                <i class="fa fa-{{ $profile['bootstrap'] }}"></i>
            </a>
        @endforeach
    </div>
</div>

<div style="border-top: 1px dashed #ccc; margin: 50px 0px 50px 0px; height: 0px;" class="center">
    <div class="relative inlineb center c999 fs24" style="top:-12px; margin: 0px auto 0px auto; background: #fff; padding: 0px 20px 0px 20px; height: 24px; line-height: 24px;">
        или
    </div>
</div>


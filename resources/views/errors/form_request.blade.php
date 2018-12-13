
@if (count($errors) > 0)
    <div class="m-alert m-alert--icon alert alert-danger" role="alert" style="">
        <div class="m-alert__icon">
            <i class="la la-warning"></i>
        </div>
        <div class="m-alert__text">
            <h4>Ошибка!</h4>
            Проверьте правильность заполнения полей.<br><br>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        {{--<div class="m-alert__close">--}}
            {{--<button type="button" class="close" data-close="alert" aria-label="Close"></button>--}}
        {{--</div>--}}
    </div>
@endif

@if (session('status'))
    <div class="m-alert m-alert--icon alert alert-success" role="alert" style="">
        <div class="m-alert__icon">
            <i class="la la-check-circle"></i>
        </div>
        <div class="m-alert__text">
            {{ session('status') }}
        </div>
        {{--<div class="m-alert__close">--}}
        {{--<button type="button" class="close" data-close="alert" aria-label="Close"></button>--}}
        {{--</div>--}}
    </div>
@endif
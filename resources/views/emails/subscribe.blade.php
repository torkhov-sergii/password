<h3>Message form subscribe form</h3>

@if(isset($data['email']))
    <br>Email: {{ $data['email'] }}
@endif

@if(isset($data['customer']))
    <br>Для замовників: так
@endif

@if(isset($data['users']))
    <br>Для учасників: так
@endif

@if(isset($data['press']))
    <br>Для журналістів: так
@endif


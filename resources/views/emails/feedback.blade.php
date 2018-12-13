<h3>Message form freedback form</h3>

@if(isset($data['name']))
    <br>Name: {{ $data['name'] }}
@endif

@if(isset($data['mail']))
    <br>Email: {{ $data['mail'] }}
@endif

@if(isset($data['email']))
    <br>Email: {{ $data['email'] }}
@endif

@if(isset($data['phone']))
    <br>Phone: {{ $data['phone'] }}
@endif

@if(isset($data['subject']))
    <br>Subject: {{ $data['subject'] }}
@endif

@if(isset($data['message']))
    <br>Messasge: {{ $data['message'] }}
@endif

@if(isset($data['text']))
    <br>Messasge: {{ $data['text'] }}
@endif




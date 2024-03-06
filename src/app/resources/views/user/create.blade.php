@extends('app.layouts')
@section('title', 'Create a new user')

@section('content')
<div class="tab-pane active" id="login-details">
    {!! Form::open(['route' => 'users.store', 'autocomplete' => 'off']) !!}

    @include('user.fields')

    {!! Form::close() !!}
</div>
@endsection
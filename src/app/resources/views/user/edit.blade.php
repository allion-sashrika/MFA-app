@extends('app.layouts')
@section('title', 'Edit User Login Details')

@section('content')
<div class="tab-pane active" id="login-details">
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch', 'autocomplete' => 'off']) !!}

    @include('user.fields')

    {!! Form::close() !!}
</div>
@endsection
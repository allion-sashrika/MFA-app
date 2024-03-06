@if ($user->id)
    {!! Form::hidden('id', $user->id) !!}
@endif

<!-- Name Field -->
<div class="form-group col-sm-3 @error('name') has-error @enderror">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control' , 'autocomplete' => 'no']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6 @error('reduce_ability') has-error @enderror">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'no']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6 @error('password') has-error @enderror">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'no']) !!}
</div>

<!-- Password confirmation Field -->
<div class="form-group col-sm-6 @error('password_confirmation') has-error @enderror">
    {!! Form::label('password_confirmation', 'Confirm') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'autocomplete' => 'no']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('user.index') !!}" class="btn btn-default">Cancel</a>
</div>

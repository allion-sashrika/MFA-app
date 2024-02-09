@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">Email Verification</div>
            <div class="card-body">
                <form action="{{ route('twofactor') }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="otp" class="col-md-4 col-form-label text-md-end text-start">Your OTP</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp">
                            @if ($errors->has('otp'))
                            <span class="text-danger">{{ $errors->first('otp') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                        <br/>
                        <a href="{{ route('resendOTP') }}" class="col-md-3 offset-md-5 btn btn-link">Resend OTP Code</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
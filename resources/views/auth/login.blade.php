@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="card-header">
        <h4>{{ __('Login') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="username">{{ __('Username') }}</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                    name="username" value="{{ old('username') }}" tabindex="1" required autocomplete="username"
                    placeholder="{{ __('Username') }}" autofocus>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" tabindex="2" required autocomplete="current-password"
                    placeholder="{{ __('Password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                </div>
            </div>

            <div class="form-group">
                <div class="h-captcha" data-sitekey="000484ce-06c4-4b74-9106-677ae584cdb2"></div>
                @error('h-captcha-response')
                    <span class="text-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
@endpush
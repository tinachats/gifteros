@include('layouts.includes.account-header')
<div class="account-box shadow-lg bg-whitesmoke rounded p-3 mt-2">
    <h5 class="font-600 lead-2x">Sign in</h5>
    <p class="font-500">
        Sign in for a personalized shopping experience.
    </p>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group mb-1 pb-1">
            <label for="email" class="mb-0 font-600 text-sm">Email</label>
            <input type="email" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="email">
            @error('email')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-1 pb-1">
            <label for="password" class="mb-0 font-600 text-sm">Password</label>
            <input type="password" name="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password">
            @error('password')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="custom-control custom-checkbox d-flex align-items-center">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">
                    <small> {{ __('Remember Me') }}</small>
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-600">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-sm btn-primary rounded-pill lead font-600 btn-block">
            <span class="text-white">Sign in</span>
        </button>
    </form>

    <div class="flex-column justify-content-center">
        <div class="division-block">
            <hr class="divider d-flex justify-content-center">
            <strong class="divider-title text-uppercase text-muted">or</strong>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-2">
            <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn" title="Sign-in with Facebook">
                <i class="fa fa-facebook text-primary-inverse"></i>
            </a>
            <a role="button" href="" class="btn btn-outline-primary btn-sm mx-3 social-login-btn" title="Sign-in with Google">
                <i class="fa fa-google text-primary-inverse"></i>
            </a>
            <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn mr-3" title="Sign-in with Twitter">
                <i class="fa fa-twitter text-primary-inverse"></i>
            </a>
            <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn" title="Sign-in with LinkedIn">
                <i class="fa fa-linkedin text-primary-inverse"></i>
            </a>
        </div>
    </div>

    <hr>
    <div class="d-flex align-items-center w-100">
        Don't have an account? <a href="/register" class="ml-1 d-flex align-items-center">Sign-Up <i class="fa fa-caret-right ml-1"></i></a>
    </div>

</div>
@include('layouts.includes.account-footer')


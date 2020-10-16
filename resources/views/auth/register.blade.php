@include('layouts.includes.account-header')
<div class="account-box shadow-lg bg-whitesmoke rounded p-3 mt-2">
    <h5 class="font-600 lead-2x">Create Account</h5>
    <form method="post" action="{{ route('register') }}" id="regForm" class="needs-validation" novalidate>
        @csrf
        <div class="form-group mb-1 pb-1">
            <label for="name" class="mb-0 font-600 text-sm">Your name</label>
            <input type="text" name="name" id="name" class="form-control form-control-sm text-capitalize @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-1 pb-1">
            <label for="email" class="mb-0 font-600 text-sm">Email</label>
            <input type="email" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-1 pb-1">
            <label for="password" class="mb-0 font-600 text-sm">Password</label>
            <input type="password" name="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password">
            <small class="d-flex align-items-center">
                <i class="text-primary material-icons mr-1">info_outline</i>
                Passwords must be at least 6 characters.
            </small>
            @error('password')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-1 pb-1">
            <label for="password_confirmation" class="mb-0 font-600 text-sm">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation">
            @error('password_confirmation')
                <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-1 pb-1">
            <button type="submit" class="btn btn-primary btn-sm btn-block">Create your Targets account</button>
        </div>
        <p class="text-sm">
            By creating an account, you agree to Targets'<a href="/terms" class="ml-1">Conditions of Use</a> and <a href="/terms" class="ml-1">Privacy Notice</a>.
        </p>
        <hr>
        <div class="d-flex align-items-center w-100">
            Already have an account? <a href="/login" class="ml-1 d-flex align-items-center">Sign-In <i class="fa fa-caret-right ml-1"></i></a>
        </div>
    </form>
</div>
@include('layouts.includes.account-footer')
            
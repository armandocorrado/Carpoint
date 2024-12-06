@extends('layouts.app')

@section('content')
    <div class="login">
        <div class="d-flex justify-content-center">
            <div class="card-deck d-md-flex justify-content-center">
                <div class="col-md-12 col-sm-12 mx-auto">
                    <div class="card mt-5 mb-3 cardGeneral">
                        <div class="card-header text-header text-center mt-3">
                            <h5 class="mt-2">Sign up</h5>
                            <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="50%" class="mt-3">

                        </div>
                        <div class="card-body text-primary mt-0 ">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="col-xs-4 mt-2">
                                    <div class="" data-validate="Inserire nome utente">
                                        <label>Utente</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-xs-4 mt-2">
                                    <div class="" data-validate="Inserire email valdida">
                                        <label>Email</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-xs-4 mt-2">
                                    <div class="" data-validate="Inserire password valdida">
                                        <label>Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="col-xs-4 mt-2">
                                    <div class="" data-validate="Conferma password">
                                        <label>Conferma password</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">

                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <button type="submit" class="btn btn-hover color-2 btnSearch d-block mt-4 mb-2">
                                    {{ __('Salva') }}
                                </button>

                                <p class="mt-5 text-center" style="font-size: 13px;color:black">Software sviluppato da ITLAB S.r.l.</p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label ">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-12 col-form-label ">{{ __('Email Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-12 col-form-label ">{{ __('Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-12 col-form-label ">{{ __('Confirm Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

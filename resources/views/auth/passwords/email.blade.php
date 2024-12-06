@extends('layouts.app')

@section('content')
<div class="container">

    <div class="login">
        <div class="container mt-5">
            <div class=" row justify-content-center">
                <div class="col-md-6 col-sm-6 mx-auto">
                    <div class="card-deck d-md-flex justify-content-center mx-auto" 
                    data-aos="zoom-in-down"
        data-aos-offset="200"
        data-aos-delay="10"
        data-aos-duration="1000">
    
                        <div class="card mb-3 cardGeneral cardRicerca">
                            <div class="card-header text-header text-center">
                                <h5 class="mt-4">Reset Password</h5>
                                <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="50%" class="mt-3">
                            </div>
                            <div class="card-body mt-3 text-primary">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
    
                                    <div class="form-group">
                                        <label for="email" class="mb-1">{{ __('Email') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

    
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
    
                                   
    
                                    
    
                                    <button type="submit" class="btn-hover color-2 mt-4">Salva</button>
    
                                   
    
                                        <p class="mt-5 text-center" style="font-size: 13px;color:black">Software sviluppato da ITLAB S.r.l.</p>
                                 
    
    
                                </form>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
    
         
    
    
        </div>
        </div>
    
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
          AOS.init();
        </script>


    
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Passwords') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="ricercaVeicoli mt-5">

        @if (Session::get('status'))
        <div class="justify-content-center">
            <div class="alert alert-success alert-dismissible text-blue mx-auto" role="alert">
                <span class="text-sm">{{ Session::get('status') }} </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-center">





        </div>
    </div>

@endsection



@extends('layouts.app')

@section('content')
    @if(session()->has('status'))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-success">
                        {{ session()->get('status') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <ldap-auth
        initial-server="{{ config('ldap.ip') }}"
        initial-port="{{ config('ldap.port') }}"
        initial-email="{{ auth()->user()->email }}"
    ></ldap-auth>
@endsection

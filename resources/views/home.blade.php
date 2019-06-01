@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/login.css')}}" type="text/css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.who')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

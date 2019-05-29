@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <div class="search-container">
            <p class="heading-title shadow">Public</p>
            <div class="heading shadow rounded">
                <div class="inner-heading">
                    <h4 id="display">Public Lists</h4>

                </div>
                {{--<hr>--}}
            </div>
        </div>
        <div class="heading searching shadow rounded">
            <div class="inner-heading search-bar">
                {!! Form::open(['action'=>'DictionariesController@search','method'=>'GET','class'=>'search-form']) !!}

                <div class="input-group">

                    {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                    {{Form::select('language', ['E' => 'English', 'K' => 'Korean'],$selectOption,['class'=>'btn-select dropdown-toggle'])}}

                    {{Form::button('<i class="fas fa-search"></i>',['class'=>'btn-search','type'=>'submit'])}}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="outer-def-container shadow rounded">

    </div>
@endsection

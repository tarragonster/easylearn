@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <p class="heading-title lower-small-title" style="display: none;">Dictionary</p>
        <div class="search-container">
            <p class="heading-title upper-small-title">Dictionary</p>
            <div class="heading">
                <div class="inner-heading">
                    <h4 id="display">{{$display}}

                        @if($selectOption=='E' && $display!='')
                            <input onclick='responsiveVoice.speak("{{$display}}","UK English Male");' type='button'
                                   value='🔊'
                                   class="speaker"/>
                        @elseif($selectOption=='K' && $display!='')
                            <input onclick='responsiveVoice.speak("{{$display}}","Korean Female");' type='button'
                                   value='🔊'
                                   class="speaker"/>
                        @endif</h4>

                    <span id="style">{{$type}}&nbsp</span> <span id="spelling">{{$spelling}}</span> <br>
                </div>
                {{--<hr>--}}
            </div>
        </div>
        <div class="heading searching">
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

    @if(Auth::check())
    <div class="userId d-none">{{Auth::user()->id}}</div>
    @endif

    <div class="outer-def-container">
        @if(count($defs)>0)
            @foreach($defs as $def)
                @if($def !='')
                    <div class="def-container">
                        <div class="inner-def">
                            <div class="def-content">
                                <h5 class="text-def theDef{{++$n}}">{{substr($def,0,-1)}}</h5>
                                @if(count($example)>0)
                                    @if($example[++$t] !='')
                                        <h6 class="theExample"
                                            style="font-weight: bolder; font-style: italic">{{substr($example[$t],7,-7)}}</h6>
                                    @endif
                                @endif
                                <div class="dropdown">
                                    {{Form::button('<i class="fas fa-plus-circle"></i> save',['class'=>"btn-dropdown",'type'=>'button' , 'data-toggle'=>"dropdown"])}}

                                    <ul class="dropdown-menu columnsFilterDropDownMenu search-dropdown">

                                        @if(Auth::check())
                                            <div class="inner-list">
                                                <li class="list{{$n}}">
                                                    {{--@if(count($searches)>0)--}}
                                                    {{--@foreach($searches as $search)--}}
                                                    {{--<div>--}}
                                                    {{--{{Form::checkbox('defaultCheck'.$k++, '','',['class'=>'form-check-input','onClick'=>'modalAfterCheck(this.id, this.name)', 'id'=>'defaultCheck'.$k, 'name'=>'#exampleModalCenter'.$n])}}--}}
                                                    {{--{{Form::label('defaultCheck'.$k,$search->list,['class'=>'form-check-label'])}}--}}
                                                    {{--</div>--}}
                                                    {{--@endforeach--}}
                                                    {{--@endif--}}
                                                </li>
                                            </div>
                                            {{Form::button('+ Create new list',['class'=>"custom-btn", 'data-toggle'=>'modal', 'data-target'=>'#exampleModalCenter'.$n])}}
                                        @else
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    {{--Create new lists modal--}}
    <!-- Modal -->
    {!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form', 'enctype'=>'multipart/form-data']) !!}
    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header create-list">
                    <div class="outer-title">
                        <strong>
                            {{ Form::label('newList', 'Create list:')}}
                        </strong>
                        {{Form::text('newList','',['class'=>'input-title','placeholder'=>'Enter list name'])}}
                    </div>

                    {{Form::button('<span aria-hidden="true">&times;</span>',
                    ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}

                </div>
                <div class="modal-body">
                    <div class="form-group row d-none">
                        {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                        </div>
                    </div>

                    <div class="body-top">
                        {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                        <div class="outer-word">
                            {{Form::text('word',$display,['class'=>'inner-word'])}}
                        </div>

                        <div class="outer-example">
                            <input list="browsers" id="example" class="inner-example" placeholder="example"
                                   name="example" autocomplete="off"/>
                            <datalist id="browsers">
                                @foreach($example as $eleExample)
                                    <option value="{{substr($eleExample,7,-7)}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('type',$type,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('pronunciation',$spelling,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::textarea('def',$defs[0],['class'=>'form-control', 'style'=>'height:60px'])}}
                        </div>
                    </div>

                    <div class="def-desc">
                        <h6>{{$defs[0]}}</h6>
                    </div>

                    <div class="outer-upload">
                        {{Form::label('update_image0', 'Upload File', ['class'=>"upload-button"])}}
                        {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)', 'id'=>'update_image0'])}}
                        {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                        <div class="imageURLinput"></div>
                    </div>
                    <div class="outer-image">
                        <img class="review-image" src=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                    {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <!-- Modal -->
    {!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header create-list">
                    <div class="outer-title">
                        <strong>
                            {{ Form::label('newList', 'Create list:')}}
                        </strong>
                        {{Form::text('newList','',['class'=>'input-title','placeholder'=>'Enter list name'])}}
                    </div>
                    {{Form::button('<span aria-hidden="true">&times;</span>',
                    ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
                </div>
                <div class="modal-body">
                    <div class="form-group row d-none">
                        {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                        </div>
                    </div>

                    <div class="body-top">
                        {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                        <div class="outer-word">
                            {{Form::text('word',$display,['class'=>'inner-word'])}}
                        </div>

                        <div class="outer-example">
                            <input list="browsers" id="example" class="inner-example" placeholder="example"
                                   name="example" autocomplete="off"/>
                            <datalist id="browsers">
                                @foreach($example as $eleExample)
                                    <option value="{{substr($eleExample,7,-7)}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('type',$type,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('pronunciation',$spelling,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::textarea('def',$defs[1],['class'=>'form-control', 'style'=>'height:60px'])}}
                        </div>
                    </div>

                    <div class="def-desc">
                        <h6>{{$defs[1]}}</h6>
                    </div>

                    <div class="outer-upload">
                        {{Form::label('update_image1', 'Upload File', ['class'=>"upload-button"])}}
                        {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image1'])}}
                        {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                        <div class="imageURLinput"></div>
                    </div>
                    <div class="outer-image">
                        <img class="review-image" src=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                    {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <!-- Modal -->
    {!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header create-list">
                    <div class="outer-title">
                        <strong>
                            {{ Form::label('newList', 'Create list:')}}
                        </strong>
                        {{Form::text('newList','',['class'=>'input-title','placeholder'=>'Enter list name'])}}
                    </div>
                    {{Form::button('<span aria-hidden="true">&times;</span>',
                    ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
                </div>
                <div class="modal-body">
                    <div class="form-group row d-none">
                        {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                        </div>
                    </div>

                    <div class="body-top">
                        {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                        <div class="outer-word">
                            {{Form::text('word',$display,['class'=>'inner-word'])}}
                        </div>

                        <div class="outer-example">
                            <input list="browsers" id="example" class="inner-example" placeholder="example"
                                   name="example" autocomplete="off"/>
                            <datalist id="browsers">
                                @foreach($example as $eleExample)
                                    <option value="{{substr($eleExample,7,-7)}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('type',$type,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('pronunciation',$spelling,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::textarea('def',$defs[2],['class'=>'form-control', 'style'=>'height:60px'])}}
                        </div>
                    </div>

                    <div class="def-desc">
                        <h6>{{$defs[2]}}</h6>
                    </div>

                    <div class="outer-upload">
                        {{Form::label('update_image2', 'Upload File', ['class'=>"upload-button"])}}
                        {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image2'])}}
                        {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                        <div class="imageURLinput"></div>
                    </div>
                    <div class="outer-image">
                        <img class="review-image" src=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                    {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <!-- Modal -->
    {!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
    <div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header create-list">
                    <div class="outer-title">
                        <strong>
                            {{ Form::label('newList', 'Create list:')}}
                        </strong>
                        {{Form::text('newList','',['class'=>'input-title','placeholder'=>'Enter list name'])}}
                    </div>
                    {{Form::button('<span aria-hidden="true">&times;</span>',
                    ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
                </div>
                <div class="modal-body">
                    <div class="form-group row d-none">
                        {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                        </div>
                    </div>

                    <div class="body-top">
                        {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                        <div class="outer-word">
                            {{Form::text('word',$display,['class'=>'inner-word'])}}
                        </div>

                        <div class="outer-example">
                            <input list="browsers" id="example" class="inner-example" placeholder="example"
                                   name="example" autocomplete="off"/>
                            <datalist id="browsers">
                                @foreach($example as $eleExample)
                                    <option value="{{substr($eleExample,7,-7)}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('type',$type,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('pronunciation',$spelling,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::textarea('def',$defs[3],['class'=>'form-control', 'style'=>'height:60px'])}}
                        </div>
                    </div>

                    <div class="def-desc">
                        <h6>{{$defs[3]}}</h6>
                    </div>

                    <div class="outer-upload">
                        {{Form::label('update_image3', 'Upload File', ['class'=>"upload-button"])}}
                        {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image3'])}}
                        {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                        <div class="imageURLinput"></div>
                    </div>
                    <div class="outer-image">
                        <img class="review-image" src=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                    {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <!-- Modal -->
    {!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
    <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header create-list">
                    <div class="outer-title">
                        <strong>
                            {{ Form::label('newList', 'Create list:')}}
                        </strong>
                        {{Form::text('newList','',['class'=>'input-title','placeholder'=>'Enter list name'])}}
                    </div>
                    {{Form::button('<span aria-hidden="true">&times;</span>',
                    ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
                </div>
                <div class="modal-body">
                    <div class="form-group row d-none">
                        {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                        </div>
                    </div>

                    <div class="body-top">
                        {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                        <div class="outer-word">
                            {{Form::text('word',$display,['class'=>'inner-word'])}}
                        </div>

                        <div class="outer-example">
                            <input list="browsers" id="example" class="inner-example" placeholder="example"
                                   name="example" autocomplete="off"/>
                            <datalist id="browsers">
                                @foreach($example as $eleExample)
                                    <option value="{{substr($eleExample,7,-7)}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('type',$type,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::text('pronunciation',$spelling,['class'=>'form-control', 'style'=>'width:100px'])}}
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                        <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                            {{Form::textarea('def',$defs[4],['class'=>'form-control', 'style'=>'height:60px'])}}
                        </div>
                    </div>

                    <div class="def-desc">
                        <h6>{{$defs[4]}}</h6>
                    </div>

                    <div class="outer-upload">
                        {{Form::label('update_image4', 'Upload File', ['class'=>"upload-button"])}}
                        {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image4'])}}
                        {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                        <div class="imageURLinput"></div>
                    </div>
                    <div class="outer-image">
                        <img class="review-image" src=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                    {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="prompt-msg"></div>
    @include('searches.pop-up')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            theClickDropDown()
        })

        $('.ajax-form').on('submit', function (e) {
            e.preventDefault();
            // var data = $(this).serialize();
            var data = new FormData($(this)[0]);
            var url = $(this).attr('action');
            var post = $(this).attr('method');

            console.log(url);

            $.ajax({
                type: post,
                url: url,
                data: data,
                dataTy: 'json',
                success: function (data) {

                    $('.fade').modal('hide');
                    theClickDropDown()

                    $('.prompt-msg').append($('<span>Added to ' + data.list + '</span>')).show().delay(3000).fadeOut();
                },
                contentType: false,
                cache: false,
                processData: false,
                async: false
            });

            $.get("{{'/search/dropdown'}}",function (data) {
                var userId = $('.userId').text();

                $('.outerListSidebar').empty();
                $.each(data[0], function (i, p) {
                    n++;
                    $('.outerListSidebar').append($('<div id="div-link"><h3 class="contain-link">' +
                        '<a class="side-link" href="/lists/'+p.list+'/practice/'+userId+'"><i class="fas fa-folder"></i> '+p.list+'</h3></div>'))
                })
            })
        });

        var n = 0;

        function theClickDropDown(){

            $('.btn-dropdown').on('click', function () {

                $.get("{{'/search/dropdown'}}", function (data) {
                    console.log(data[0]);
                    console.log(data[1]);

                    for (var t = 1; t < 6; t++) {

                        $('.list' + t).empty();

                        $.each(data[0], function (i, p) {
                            n++;
                            $('.list' + t).append($('<input id="theList' + n + '" type="checkbox" name="#update' + t + '" onClick="modalAfterCheck(this.id,this.name,'+t+')">'))
                                .append($('<label for="theList' + n + '"></label>').val(p.list).html(p.list))
                                .append($("<br>"));

                        });

                        $('.list' + t).click(function (event) {
                            event.stopPropagation();

                        });

                        $.each(data[1], function (i, p) {

                            var count = $('.list' + 1).find("label").length;

                            if (p.definition == $('.theDef' + 1).text()) {

                                for (var s = 0; s < count; s++) {

                                    if (p.list === $('.list' + 1).find($("label")[s]).val()) {

                                        var idInput1 = $('.list' + 1).find($("label")[s]).attr('for');

                                        $('.list' + t).find('#'+idInput1).prop('checked', true)
                                    }
                                }
                            }

                            var count1 = $('.list' + 2).find("label").length + count;
                            if (p.definition == $('.theDef' + 2).text()) {
                                for (var a = count; a < count1; a++) {

                                    if (p.list === $('.list' + 2).find($("label")[a]).val()) {

                                        var idInput2 = $('.list' + 2).find($("label")[a]).attr('for');

                                        $('.list' + t).find('#'+idInput2).prop('checked', true)
                                    }
                                }
                            }

                            var count2 = $('.list' + 3).find("label").length + count1;
                            if (p.definition == $('.theDef' + 3).text()) {
                                for (var b = count; b < count2; b++) {

                                    if (p.list === $('.list' + 3).find($("label")[b]).val()) {

                                        var idInput3 = $('.list' + 3).find($("label")[b]).attr('for');

                                        $('.list' + t).find('#'+idInput3).prop('checked', true)
                                    }
                                }
                            }

                            var count3 = $('.list' + 4).find("label").length + count2;
                            if (p.definition == $('.theDef' + 4).text()) {
                                for (var c = count; c < count3; c++) {

                                    if (p.list === $('.list' + 4).find($("label")[c]).val()) {

                                        var idInput4 = $('.list' + 4).find($("label")[c]).attr('for');

                                        $('.list' + t).find('#'+idInput4).prop('checked', true)
                                    }
                                }
                            }

                            var count4 = $('.list' + 5).find("label").length + count3;
                            if (p.definition == $('.theDef' + 5).text()) {
                                for (var d = count; d < count4; d++) {

                                    if (p.list === $('.list' + 5).find($("label")[d]).val()) {

                                        var idInput5 = $('.list' + 5).find($("label")[d]).attr('for');

                                        $('.list' + t).find('#'+idInput5).prop('checked', true)
                                    }
                                }
                            }
                        });
                    }
                });
            });
        }


        function modalAfterCheck(theId,theTarget,t) {

            if ($('#' + theId).is(":checked")) {

                $(theTarget + 'header').empty();
                $(theTarget + 'header').append($('<h5 class="popUpTitle' + theId + '"></h5>'))
                    .append($('<input type="text" class="hiddenTitle' + theId + ' d-none" id="newList" name="newList">'));
                $('.popUpTitle' + theId).text($('#' + theId).next().text());
                $('.hiddenTitle' + theId).val($('#' + theId).next().text());

                $(theTarget).modal('show');
            } else if (!$('#' + theId).is(":checked")) {
                var count = t;

                var delDef = $(".theDef"+count+"").text();

                var delList = $("label[for="+theId+"]").text();

                var delDetect = {defDel:delDef,listDel:delList};

                console.log(delDetect);

                $.ajax({
                    type: "POST",
                    url:"{{url('/search/destroy')}}",
                    data: delDetect,
                    dataTy: 'json',
                    success: function (data) {

                        $('.prompt-msg').append($('<span>Removed from ' + data + '</span>')).show().delay(4000).fadeOut();

                    },
                })

            }else{
                $(theTarget).modal('hide');
            }
        }

        //    function to review uploading images

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                $('.review-image').attr('src', "");
                reader.onload = function (e) {
                    $('.review-image')
                        .attr('src', e.target.result);

                    $(".URLinputBox").val("");
                    console.log(input.files)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        //    event after closing modal (unload images from the modal)

        $(".ajax-form").on("hidden.bs.modal", function () {

            $('.update_image').val('');
            $('.review-image').attr('src', null);
            $('.URLinputBox').val(null);
            $('.inner-example').val(null);
            $('.imageURLinput').empty();

        });

        $(".createURLimage").on('click', function () {
            $('.imageURLinput').empty();
            $('.imageURLinput').append($('<input class="URLinputBox" type="text" name="URLinputBox" oninput="displayOnImage(this);">'));
            $('.update_image').val(null);
        });

        function displayOnImage(a) {

            $('.review-image')
                .attr('src', $(a).val());
            console.log($(".URLinputBox").val());
            $('.update_image').val(null);
        }

        $('.input-title').on("input",function () {
            $(this).val(capitalizeFirstLetter($(this).val()))
        })

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>

@endsection

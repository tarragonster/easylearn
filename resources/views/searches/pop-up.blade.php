{!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade" id="update1" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="update1header"></div>
                </div>
                {{Form::button('<span aria-hidden="true">&times;</span>',
                ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
            </div>
            <div class="modal-body">
                <div class="form-group row d-none">
                    {{ Form::label('lang', 'Language',['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10">
                        {{Form::text('lang',$selectOption,['class'=>'form-control', 'style'=>'width:100px', 'readonly'=>'true'])}}
                    </div>
                </div>

                <div class="body-top">
                    {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                    <div class="outer-word">
                        {{Form::text('word',$display,['class'=>'inner-word'])}}
                    </div>

                    <div class="outer-example">
                        <input list="browsers" id="example" class="inner-example" placeholder="example" name="example" autocomplete="off"/>
                        <datalist id="browsers">
                            @foreach($example as $eleExample)
                                <option value="{{substr($eleExample,7,-7)}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row  d-none">
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
                <div class="form-group row  d-none">
                    {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                        {{Form::textarea('def',$defs[0],['class'=>'form-control', 'style'=>'height:60px'])}}
                    </div>
                </div>

                <div class="def-desc">
                    <h6 class="inner-def-desc">{{$defs[0]}}</h6>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image5', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image5'])}}
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

{!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade" id="update2" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="update2header"></div>
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
                        <input list="browsers" id="example" class="inner-example" placeholder="example" name="example" autocomplete="off"/>
                        <datalist id="browsers">
                            @foreach($example as $eleExample)
                                <option value="{{substr($eleExample,7,-7)}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row  d-none">
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
                <div class="form-group row  d-none">
                    {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                        {{Form::textarea('def',$defs[1],['class'=>'form-control', 'style'=>'height:60px'])}}
                    </div>
                </div>

                <div class="def-desc">
                    <h6 class="inner-def-desc">{{$defs[1]}}</h6>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image6', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image6'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                    <div class="imageURLinput"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image" src="" />
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

{!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade" id="update3" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="update3header"></div>
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
                        <input list="browsers" id="example" class="inner-example" placeholder="example" name="example" autocomplete="off"/>
                        <datalist id="browsers">
                            @foreach($example as $eleExample)
                                <option value="{{substr($eleExample,7,-7)}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row  d-none">
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
                <div class="form-group row  d-none">
                    {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                        {{Form::textarea('def',$defs[2],['class'=>'form-control', 'style'=>'height:60px'])}}
                    </div>
                </div>

                <div class="def-desc">
                    <h6 class="inner-def-desc">{{$defs[2]}}</h6>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image7', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image7'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                    <div class="imageURLinput"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image" src="" />
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

{!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade" id="update4" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="update4header"></div>
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
                        <input list="browsers" id="example" class="inner-example" placeholder="example" name="example" autocomplete="off"/>
                        <datalist id="browsers">
                            @foreach($example as $eleExample)
                                <option value="{{substr($eleExample,7,-7)}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row  d-none">
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
                <div class="form-group row  d-none">
                    {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                        {{Form::textarea('def',$defs[3],['class'=>'form-control', 'style'=>'height:60px'])}}
                    </div>
                </div>

                <div class="def-desc">
                    <h6 class="inner-def-desc">{{$defs[3]}}</h6>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image8', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image8'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                    <div class="imageURLinput"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image" src="" />
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

{!! Form::open(['action'=>'DictionariesController@store', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade" id="update5" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="update5header"></div>
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
                        <input list="browsers" id="example" class="inner-example" placeholder="example" name="example" autocomplete="off"/>
                        <datalist id="browsers">
                            @foreach($example as $eleExample)
                                <option value="{{substr($eleExample,7,-7)}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row  d-none">
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
                <div class="form-group row  d-none">
                    {{ Form::label('def', 'Definition', ['class'=>"col-sm-2 col-form-label"])}}
                    <div class="col-sm-10" style="padding-left: 30px; width: 200px">
                        {{Form::textarea('def',$defs[4],['class'=>'form-control', 'style'=>'height:60px'])}}
                    </div>
                </div>

                <div class="def-desc">
                    <h6 class="inner-def-desc">{{$defs[4]}}</h6>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image9', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image9'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                    <div class="imageURLinput"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image" src="" />
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

@if ($errors->has('duplicated_email'))
    <div class="container pt-4 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul>
                        <li style="margin-bottom: 7.5px;">{{$errors->first('duplicated_email')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($errors->has('type_not_found'))
    <div class="container pt-4 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul>
                        <li style="margin-bottom: 7.5px;">{{$errors->first('type_not_found')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

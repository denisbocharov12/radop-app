@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-filials">
                    <form action="{{route('theme.user.filial.update', $filial)}}" class="filial-store form-filial" method="POST">
                        @csrf
                        <div class="col-md-12 col-filial-heading">
                            <h1 class="heading">{{__('theme.edit_filial')}}</h1>
                        </div>
                        <hr>
                        <div class="row row-primary">
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="name">{{__('theme.filial_input_name')}}</label>
                                    <input type="text"  name="name" class="form-control-filial-input " required id="name" value="{{$filial->name}}" placeholder="{{__('theme.filial_input_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="address">{{__('theme.filial_input_address')}}</label>
                                    <input type="text" name="address" class="form-control-filial-input " required id="address" value="{{$filial->address}}" placeholder="{{__('theme.filial_input_address')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="contact_name">{{__('theme.filial_input_contact_name')}}</label>
                                    <input type="text" name="contact_name" class="form-control-filial-input"  id="contact_name" value="{{$filial->contact_name}}" placeholder="{{__('theme.filial_input_contact_name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-filial">
                                <div class="form-control-filial">
                                    <button type="submit" class="btn-filial-store">{{__('theme.update_filial')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

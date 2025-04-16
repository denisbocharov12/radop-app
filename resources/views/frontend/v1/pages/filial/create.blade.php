@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-filials">
                    <form action="{{route('theme.user.filial.store')}}" class="filial-store" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="name">Название</label>
                                    <input type="text" name="name" class="form-control-filial-input " required="" id="name" placeholder="Value">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

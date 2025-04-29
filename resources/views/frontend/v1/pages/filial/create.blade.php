@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-filials">
                    <form action="{{route('theme.user.filial.store')}}" class="filial-store form-filial" method="POST">
                        @csrf
                        <div class="col-md-12 col-filial-heading">
                            <h1 class="heading">{{__('theme.create_filial')}}</h1>
                        </div>
                        <hr>
                        <div class="row row-primary">
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="address">{{__('theme.filial_input_address')}}</label>
                                    <input type="text" name="address" class="form-control-filial-input @error('address') error @enderror" required id="name" placeholder="{{__('theme.filial_input_address')}}">
                                    @error('address')
                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="phone">{{__('theme.filial_input_phone')}}</label>
                                    <input type="text" name="phone" class="form-control-filial-input  @error('phone') error @enderror" id="phone" placeholder="{{__('theme.filial_input_phone')}}">
                                    @error('phone')
                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-filial">
                                <div class="form-control-filial">
                                    <label for="phone">{{__('theme.filial_input_city')}}</label>
                                    <select name="city_id" class="form-control-filial-input @error('city_id') error @enderror" id="city_id">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-filial">
                                <div class="form-control-filial">
                                    <button type="submit" class="btn-filial-store">{{__('theme.save_filial')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/imask"></script>
    <script>
        const element = document.getElementById('phone');
        const maskOptions = {
            mask: '{\\0} 000 00 000',
            lazy: false,
            overwrite: 'shift',
        };
        const mask = IMask(element, maskOptions);

        const codFisk = document.getElementById('cod_fiscal');
        const options = {
            mask: /^\d+$/,
        };
        const maskCodFisk = IMask(codFisk, options);
    </script>
@endsection

@section('scripts')

@endsection

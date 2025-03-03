@extends('frontend.v1.layouts.layout-without-errors')

@section('content')
    <div class="section-standart section-register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-register-wrap">
                    <div id="tabs">
                        <div class="tab-block">
                            <div class="tab {{old('type_id')  === "1" ? 'active' : ''}} {{old('type_id')  === null ? 'active' : ''}}">{{__('theme.physical-person')}}</div>
                            <div class="tab {{old('type_id')  === "2" ? 'active' : ''}} {{old('type_id') !== null && old('type_id')  === "2" ? 'active show-important-active' : ''}}">{{__('theme.legal-person')}}</div>
                        </div>
                        @include('frontend.v1.pages.registration.components.fiz')
                        @include('frontend.v1.pages.registration.components.iur')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        var tab;
        var tabContent;

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);
        };

        document.getElementById('tabs').onclick = function (event) {
            var target = event.target;
            if (target.className == 'tab') {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        };

        function hideTabsContent(a) {
            for (var i = a; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add('hide');
                tab[i].classList.remove('active');
            }
        }

        function showTabsContent(b) {
            if (tabContent[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('active');
                tabContent[b].classList.remove('hide');
                tabContent[b].classList.add('show');
            }
        }
    </script>
@endsection

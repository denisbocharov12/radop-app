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


@extends('frontend.v1.layouts.layout-without-errors')

@section('content')
    <div class="section-standart section-register">
        <div class="container" id="container">
            <div class="registration-block" onclick="showIurForm()">
                <p class="registration-block-title"><strong>{{__('theme.registration-juridical-person')}} *</strong></p>
                <p>* {{__('theme.registration-juridical-person-text-1')}}</p>
                <p>{{__('theme.registration-juridical-person-text-2')}}</p>
                <p>022 78 21 12 / 079 78 21 12</p>
                <p>{{__('theme.registration-juridical-person-text-3')}} support@radop.md</p>
            </div>
            <div class="registration-block" onclick="showWarning()">
                <p class="registration-block-title"><strong>{{__('theme.registration-physical-person')}} *</strong></p>
                <p>{{__('theme.registration-physical-person-text-1')}}</p>
                <p>{{__('theme.registration-physical-person-text-2')}}</p>
                <p>{{__('theme.registration-physical-person-text-3')}}</p>
                <p>{{__('theme.registration-physical-person-text-4')}}</p>
            </div>
            <div id="iur-form" style="display: none;">
                <h2 class="mb-3">{{__('theme.registration')}}</h2>
                @include('frontend.v1.pages.registration.components.iur')
            </div>
        </div>
        <div id="warning">⚠️ {{__('theme.registration-warning-text')}}</div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script>
        // function showIurForm() {
        //     let iurForm = document.getElementById("iur-form");
        //     iurForm.style.display = "block";
        //     let warning = document.getElementById("warning");
        //     warning.style.display = "none";
        //     let registrationBlocks = document.getElementsByClassName('registration-block')
        //     Array.from(registrationBlocks).forEach(function(block) {
        //         block.style.display = 'none';
        //     });
        //     let container = document.getElementById('container');
        //     container.style.display = "block";
        // }
        // function showWarning() {
        //     let warning = document.getElementById("warning");
        //     warning.style.display = "block";
        // }
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".rule-checkbox");
            const submitButton = document.getElementById("form_submit_iur");

            function updateSubmitButtonState() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                submitButton.disabled = !allChecked;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateSubmitButtonState);
            });

            updateSubmitButtonState();
        });
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password_iur");
            const lengthRule = document.getElementById("length-rule");
            const uppercaseRule = document.getElementById("uppercase-rule");
            const symbolRule = document.getElementById("symbol-rule");

            passwordInput.addEventListener("input", function () {
                const password = passwordInput.value;

                if (password.length >= 8 && password.length <= 20) {
                    lengthRule.textContent = "✅ {{__('theme.password-rule-length')}}";
                    lengthRule.classList.add("valid");
                    lengthRule.classList.remove("invalid");
                } else {
                    lengthRule.textContent = "❌ {{__('theme.password-rule-length')}}";
                    lengthRule.classList.add("invalid");
                    lengthRule.classList.remove("valid");
                }

                if (/[A-Z]/.test(password)) {
                    uppercaseRule.textContent = "✅ {{__('theme.password-rule-uppercase-letter')}}";
                    uppercaseRule.classList.add("valid");
                    uppercaseRule.classList.remove("invalid");
                } else {
                    uppercaseRule.textContent = "❌ {{__('theme.password-rule-uppercase-letter')}}";
                    uppercaseRule.classList.add("invalid");
                    uppercaseRule.classList.remove("valid");
                }

                if (!/[!@#$%*&]/.test(password)) {
                    symbolRule.textContent = "✅ {{__('theme.password-rule-special-symbols')}}";
                    symbolRule.classList.add("valid");
                    symbolRule.classList.remove("invalid");
                } else {
                    symbolRule.textContent = "❌ {{__('theme.password-rule-special-symbols')}}";
                    symbolRule.classList.add("invalid");
                    symbolRule.classList.remove("valid");
                }
            });
        });
        $(document).ready(function(){
            $(".select2-registration").select2();
            const element = document.getElementById('phone_iur');
            const maskOptions = {
                mask: '{\\0} 00 00 00 00',
                lazy: false,
                overwrite: 'shift',
            };
            const mask = IMask(element, maskOptions);

            const codFisk = document.getElementById('cod_fiscal');
            const options = {
                mask: /^\d+$/,
            };
            const maskCodFisk = IMask(codFisk, options);
        })
    </script>
@endsection


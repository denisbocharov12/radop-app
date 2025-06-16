@extends('frontend.v1.layouts.layout-without-errors')

@section('content')
    <div class="section-standart section-register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-register-wrap">
                    <h2 class="theme-registration-heading">{{__('theme.registration')}}</h2>
                    <div id="tabs">
                        <div class="tab-block">
                            <div class="tab {{old('type_id')  === "2" ? 'active' : ''}} {{old('type_id') === null ? 'active' : ''}}">{{__('theme.legal-person')}}</div>
                            <div class="tab {{old('type_id')  === "1" ? 'active' : ''}} {{old('type_id')  !== null && old('type_id')  === "2" ? 'active  show-important-active' : ''}}">{{__('theme.physical-person')}}</div>
                        </div>
                        @include('frontend.v1.pages.registration.components.iur')
                        @include('frontend.v1.pages.registration.components.fiz')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
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
        // document.addEventListener("DOMContentLoaded", function () {
        //     const checkboxesFiz = document.querySelectorAll(".rule-checkbox-fiz");
        //     const checkboxesIur = document.querySelectorAll(".rule-checkbox-iur");
        //     const submitButtonFiz = document.getElementById("form_submit_fiz");
        //     const submitButtonIur = document.getElementById("form_submit_iur");
        //
        //     function updateSubmitButtonStateFiz() {
        //         const allChecked = Array.from(checkboxesFiz).every(checkbox => checkbox.checked);
        //         submitButtonFiz.disabled = !allChecked;
        //     }
        //
        //     function updateSubmitButtonStateIur() {
        //         const allChecked = Array.from(checkboxesIur).every(checkbox => checkbox.checked);
        //         submitButtonIur.disabled = !allChecked;
        //     }
        //
        //     checkboxesFiz.forEach(checkbox => {
        //         checkbox.addEventListener("change", updateSubmitButtonStateFiz);
        //     });
        //
        //     checkboxesIur.forEach(checkbox => {
        //         checkbox.addEventListener("change", updateSubmitButtonStateIur);
        //     });
        //
        //     updateSubmitButtonStateFiz();
        //     updateSubmitButtonStateIur();
        // });
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInputIur = document.getElementById("password_iur");
            const passwordInputFiz = document.getElementById("password_fiz");
            const lengthRuleFiz = document.getElementById("length-rule-fiz");
            const lengthRuleIur = document.getElementById("length-rule-iur");

            passwordInputIur.addEventListener("input", function () {
                const password = passwordInputIur.value;

                if (password.length >= 8 && password.length <= 20) {
                    lengthRuleIur.textContent = "✅ {{__('theme.password-rule-length')}}";
                    lengthRuleIur.classList.add("valid");
                    lengthRuleIur.classList.remove("invalid");
                } else {
                    lengthRuleIur.textContent = "❌ {{__('theme.password-rule-length')}}";
                    lengthRuleIur.classList.add("invalid");
                    lengthRuleIur.classList.remove("valid");
                }
            });

            passwordInputFiz.addEventListener("input", function () {
                const password = passwordInputFiz.value;

                if (password.length >= 8 && password.length <= 20) {
                    lengthRuleFiz.textContent = "✅ {{__('theme.password-rule-length')}}";
                    lengthRuleFiz.classList.add("valid");
                    lengthRuleFiz.classList.remove("invalid");
                } else {
                    lengthRuleFiz.textContent = "❌ {{__('theme.password-rule-length')}}";
                    lengthRuleFiz.classList.add("invalid");
                    lengthRuleFiz.classList.remove("valid");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxesIur = document.querySelectorAll(".rule-checkbox-iur");
            const checkboxesFiz = document.querySelectorAll(".rule-checkbox-fiz");
            const submitButtonIur = document.getElementById("form_submit_iur");
            const submitButtonFiz = document.getElementById("form_submit_fiz");

            function updateSubmitButtonStateIur() {
                const allChecked = Array.from(checkboxesIur).every(checkbox => checkbox.checked);
                submitButtonIur.disabled = !allChecked;
            }

            function updateSubmitButtonStateFiz() {
                const allChecked = Array.from(checkboxesFiz).every(checkbox => checkbox.checked);
                submitButtonFiz.disabled = !allChecked;
            }

            checkboxesIur.forEach(checkbox => {
                checkbox.addEventListener("change", updateSubmitButtonStateIur);
            });

            checkboxesFiz.forEach(checkbox => {
                checkbox.addEventListener("change", updateSubmitButtonStateIur);
            });

            updateSubmitButtonStateIur();
            updateSubmitButtonStateFiz();
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

            const phoneFiz = document.getElementById('phone_fiz');
            const optionsPhoneFiz = {
                mask: '{\\0} 00 00 00 00',
                lazy: false,
                overwrite: 'shift',
            };
            const maskPhoneFiz = IMask(phoneFiz, optionsPhoneFiz);

            // EYE
            $(".eye_fiz").on("click", function (e) {
                var t, c;
                e.preventDefault();
                var t = $("#password_fiz").attr("type");
                var c = $(this).find("i").attr("class");
                if (c == "fa fa-eye") {
                    $(this).find("i").removeClass("fa-eye");
                    $(this).find("i").addClass("fa-eye-slash");
                } else {
                    $(this).find("i").addClass("fa-eye");
                    $(this).find("i").removeClass("fa-eye-slash");
                }
                if (t == "password") {
                    $("#password_fiz").attr("type", "text");
                } else {
                    $("#password_fiz").attr("type", "password");
                }
            });

            $('.eye_fiz_confirm').on("click", function (e) {
                var t, c;
                e.preventDefault();
                var t = $("#password_confirmation_fiz").attr("type");
                var c = $(this).find("i").attr("class");
                if (c == "fa fa-eye") {
                    $(this).find("i").removeClass("fa-eye");
                    $(this).find("i").addClass("fa-eye-slash");
                } else {
                    $(this).find("i").addClass("fa-eye");
                    $(this).find("i").removeClass("fa-eye-slash");
                }
                if (t == "password") {
                    $("#password_confirmation_fiz").attr("type", "text");
                } else {
                    $("#password_confirmation_fiz").attr("type", "password");
                }
            });

            $(".eye_iur").on("click", function (e) {
                var t, c;
                e.preventDefault();
                var t = $("#password_iur").attr("type");
                var c = $(this).find("i").attr("class");
                if (c == "fa fa-eye") {
                    $(this).find("i").removeClass("fa-eye");
                    $(this).find("i").addClass("fa-eye-slash");
                } else {
                    $(this).find("i").addClass("fa-eye");
                    $(this).find("i").removeClass("fa-eye-slash");
                }
                if (t == "password") {
                    $("#password_iur").attr("type", "text");
                } else {
                    $("#password_iur").attr("type", "password");
                }
            });

            $('.eye_iur_confirm').on("click", function (e) {
                var t, c;
                e.preventDefault();
                var t = $("#password_confirmation_iur").attr("type");
                var c = $(this).find("i").attr("class");
                if (c == "fa fa-eye") {
                    $(this).find("i").removeClass("fa-eye");
                    $(this).find("i").addClass("fa-eye-slash");
                } else {
                    $(this).find("i").addClass("fa-eye");
                    $(this).find("i").removeClass("fa-eye-slash");
                }
                if (t == "password") {
                    $("#password_confirmation_iur").attr("type", "text");
                } else {
                    $("#password_confirmation_iur").attr("type", "password");
                }
            });
        })
    </script>
@endsection

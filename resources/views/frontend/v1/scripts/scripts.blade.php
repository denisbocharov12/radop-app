<!-- JavaScript -->
<script src="{{asset('/v1/frontend/assets')}}/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/select2/select2.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/fancybox/jquery.fancybox.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/slick/slick.min.js"></script>

<script src="{{asset('/v1/frontend/assets')}}/js/scripts.js"></script>


<script>
    $(document).on('click','#login-btn-modal',function (e) {
        e.preventDefault();
        var token = "{{csrf_token()}}";
        var path = "{{route('user.login')}}";
        var form = $('#form-login-modal');
        var username = $('#form-login-modal .input-login[type=text]').val();
        var password = $('#form-login-modal .input-password[type=password]').val();
        $.ajax({
            url: path,
            type: "POST",
            dataType:"JSON",
            data: {
                username: username,
                password: password,
                _token: token
            },
            beforeSend:function () {
                $('#loginModal').find('.login-modal-wrap').css({ "display": "flex", "justify-content": "center","font-size":"30px" });
                $('#loginModal').find('.login-modal-wrap').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success:function (response) {
                if (response['status']){
                    $('#loginModal').html(response['html']);
                } else {
                    $('#loginModal').html(response['html']);
                }
            }
        });
    });
</script>
@yield('scripts')

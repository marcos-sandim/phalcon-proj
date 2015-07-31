<div class="login-box">
    <div class="login-logo">
        {{ link_to('/', '<img class="logo-lg" src="/img/logo_h.png" alt="VGPG"></img>', 'class': 'logo') }}
    </div>
    <div class="login-box-body">
        <p class="login-box-msg"><i class="fa fa-lock"></i> {{ _('SESSION LOGIN FORM HEADER') }}</p>
        {{ form }}
        {{ link_to('session/forgotPassword', _('SESSION LOGIN FORM FORGOT PASSWORD LABEL')) }}
    </div>
</div>

{{ javascript_include('/js/jquery.js') }}
{{ javascript_include('/js/bootstrap.min.js') }}
{{ javascript_include('/js/icheck.min.js') }}
<script>
    $(function() {
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
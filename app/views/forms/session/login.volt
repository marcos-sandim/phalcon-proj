<h2>Log In</h2>

{{ content() }}

{{ form('session/login', 'method': 'post', 'class': 'form-horizontal') }}


    <div class="form-group">
        <label class="col-sm-3 control-label" for="email">Email</label>
        <div class="col-sm-9">
            {{ element.render('email') }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="password">Password</label>
        <div class="col-sm-9">
            {{ element.render('password') }}
        </div>
    </div>

    {{ element.render('login') }}

    <div align="center" class="remember">
        {{ element.render('remember') }}
        {{ element.label('remember') }}
    </div>

    {{ element.render('csrf', ['value': security.getSessionToken()]) }}

    <hr>

    <div class="forgot">
        {{ link_to("session/forgotPassword", "Forgot my password") }}
    </div>

{{ end_form() }}

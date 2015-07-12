{{ content() }}

{{ form('user/create', 'method': 'post') }}

<div class="form-group">
    <label for="name">{{ element.label('name') }}</label>
    {{ element.render("name") }}
    {{ element.messages('name') }}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ element.label('email') }}</label>
            {{ element.render("email") }}
            {{ element.messages('email') }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">{{ element.label('phone') }}</label>
            {{ element.render("phone") }}
            {{ element.messages('phone') }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">{{ element.label('password') }}</label>
            {{ element.render("password") }}
            {{ element.messages('password') }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="confirmPassword">{{ element.label('confirmPassword') }}</label>
            {{ element.render("confirmPassword") }}
            {{ element.messages('confirmPassword') }}
        </div>
    </div>
</div>

<div>
{{ element.render('submit') }}
</div>

{{ end_form() }}
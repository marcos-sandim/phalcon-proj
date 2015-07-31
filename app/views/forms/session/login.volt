{{ content() }}

{{ form(element.getAction(), 'method': 'post') }}
    {{ element.renderDecorated('email') }}
    {{ element.renderDecorated('password') }}
    {{ element.render('csrf') }}
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                {{ element.render('remember') }} {{ element.label('remember') }}
            </div>
        </div>
        <div class="col-xs-4">
            {{ element.render('login') }}
        </div>
    </div>
{{ end_form() }}
{{ form(element.getAction(), 'method': 'post') }}
    <div class="row">
        <div class="col-md-6">
            {{ element.renderDecorated('password') }}
        </div>
        <div class="col-md-6">
            {{ element.renderDecorated('confirmPassword') }}
        </div>
    </div>

    <div>
    {{ element.render('submit') }}
    </div>
{{ end_form() }}

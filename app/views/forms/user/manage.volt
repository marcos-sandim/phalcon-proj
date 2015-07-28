{{ content() }}

{{ form(element.getAction(), 'method': 'post') }}
    <div class="row">
        <div class="col-md-8">
            {{ element.renderDecorated('name') }}
        </div>
        <div class="col-md-4">
            {{ element.renderDecorated('role') }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            {{ element.renderDecorated('email') }}
        </div>
        <div class="col-md-6">
            {{ element.renderDecorated('phone') }}
        </div>
    </div>
    {% if element.has('password') %}
        <div class="row">
            <div class="col-md-6">
                {{ element.renderDecorated('password') }}
            </div>
            <div class="col-md-6">
                {{ element.renderDecorated('confirmPassword') }}
            </div>
        </div>
    {% endif %}

    <div>
    {{ element.render('submit') }}
    </div>

{{ end_form() }}
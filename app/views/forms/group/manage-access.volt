{{ form(element.getAction(), 'method': 'post') }}
    {% for resource in element.getResources() %}
    <div class="row">
        <div class="col-md-8">
            {{ resource.name }}
        </div>
        <div class="col-md-4">
            <div class="checkbox icheck top-margin-30">
                {{ element.render(resource.name) }}
            </div>
        </div>
    </div>
    {% endfor %}

    <div>
    {{ element.render('submit') }}
    </div>

{{ end_form() }}
{% do assets.addCss('/css/bootstrap-switch.min.css') %}
{% do assets.addJs('/js/bootstrap-switch.min.js') %}
{% do start_js_buff() %}
<script>
$(function() {
    $('.icheck input').bootstrapSwitch({
        'onText': '{{ _('GROUP MANAGE ACCESS FORM ALLOW LABEL') }}',
        'offText': '{{ _('GROUP MANAGE ACCESS FORM DENY LABEL') }}',
        'onColor': 'success',
        'offColor': 'danger'
    });

    /*iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    })*/;
});
</script>
{% do end_js_buff() %}

{{ form(element.getAction(), 'method': 'post') }}
    <div class="row">
        <div class="col-md-8">
            {{ element.renderDecorated('name') }}
        </div>
        <div class="col-md-4">
            <div class="checkbox icheck top-margin-30">
                {{ element.render('is_admin') }} {{ element.label('is_admin') }}
            </div>
        </div>
    </div>

    <div>
    {{ element.render('submit') }}
    </div>

{{ end_form() }}
{% do assets.addCss('/css/icheck.css') %}
{% do assets.addJs('/js/icheck.min.js') %}
{% do start_js_buff() %}
<script>
$(function() {
    $('.icheck input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
</script>
{% do end_js_buff() %}

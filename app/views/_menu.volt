<ul class="sidebar-menu">
    <li class="header">{{ _('APPLICATION MENU HEADER') }}</li>
    {% for item in this.menu %}
    <li class="treeview">
        {% if item['icon'] %}
            {% set title = '<i class="fa fa-fw ' ~ item['icon'] ~ '"></i> <span>' ~ _(item['title']) ~ '</span>' %}
        {% else %}
            {% set title = item['title'] %}
        {% endif %}
        {{ acl_link(item['resource'], title) }}
    </li>
{% endfor %}
</ul>

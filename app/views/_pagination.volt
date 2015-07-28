{% if parameters is not defined %}
    {% set parameters = [] %}
{% endif %}
{% set total = paginator ? paginator.total_items : 0 %}

{% set page = paginator.current %}
{% set pages = paginator.total_pages %}
{% set chunk = 5 %}
{% if chunk > pages %}
    {% set chunk = pages %}
{% endif %}
{% set chunkStart = (page - (floor(chunk / 2)))|int %}
{% set chunkEnd = (page + (ceil(chunk / 2) - 1))|int %}
{% if chunkStart < 1 %}
    {% set adjust = 1 - chunkStart %}
    {% set chunkStart = 1 %}
    {% set chunkEnd = chunkEnd + adjust %}
{% endif %}
{% if chunkEnd > pages %}
    {% set adjust = chunkEnd - pages %}
    {% set chunkStart = chunkStart - adjust %}
    {% set chunkEnd = pages %}
{% endif %}
{% set page_range = chunkStart..chunkEnd %}

<div class="pull-right">
    <span class="pagination-count">
        {% if (total == 1) %}
            {{ _('PAGINATOR ONE ITEM') }}
        {% else %}
            {{ _('PAGINATOR TOTAL ITEMS', ['total': total]) }}
        {% endif %}
    </span>
    <ul class="pagination pagination-sm">
        <!-- Previous page link -->
        {% if paginator.before is defined %}
            <li>
                {{ acl_link(['GET': ['page': paginator.before]], '«') }}
            </li>
        {% else %}
            <li class="disabled"><a href="#">«</a></li>
        {% endif %}

        {% if ((paginator) and (chunkStart > paginator.first)) %}
            <li>
                {{ acl_link(['GET': ['page': 1]], 1) }}
            </li>
            {% if (chunkStart > paginator.first + 1) %}
                <li class="disabled"><a href="#">...</a></li>
            {% endif %}
        {% endif %}
        <!-- Numbered page links -->
        {% if (paginator) %}
            {% for page in page_range %}
                {% if (page != paginator.current) %}
                    <li>
                        {{ acl_link(['GET': ['page': page]], page) }}
                    </li>
                {% else %}
                    <li class="active">
                        {{ acl_link(['GET': ['page': page]], page) }}
                    </li>
                {% endif %}
            {% endfor %}
        {%  else %}
            <li class="active"><a href="#">1</a></li>
        {% endif %}

        {% if ((paginator) and (chunkEnd < paginator.last)) %}
            {% if (chunkEnd < paginator.last - 1) %}
                <li class="disabled"><a href="#">...</a></li>
            {% endif %}
            <li>
                {{ acl_link(['GET': ['page': paginator.last]], paginator.last) }}
            </li>
        {% endif %}

        <!-- Next page link -->
        {% if paginator.next is defined %}
            <li>
                {{ acl_link(['GET': ['page': paginator.next]], '»') }}
            </li>
        {% else %}
            <li class="disabled"><a href="#">»</a></li>
        {% endif %}
    </ul>
</div>

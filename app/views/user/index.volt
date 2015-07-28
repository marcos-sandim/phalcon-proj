{{ content() }}

<div class="box">
    <div class="box-header">
        <!--<h3 class="panel-title">Panel title</h3> -->
        {{ acl_link(['controller': 'user', 'action': 'create'], '<i class="fa fa-plus"></i> Create user', ['class': 'btn btn-success btn-xs pull-right']) }}
        <div class="clearfix"></div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-bordered table-hover no-border-bottom">
            <thead>
                <tr>
                    <th class="text-center">{{ _('USER LIST NAME HEADER') }}</th>
                    <th class="text-center">{{ _('USER LIST EMAIL HEADER') }}</th>
                    <th class="text-center">{{ _('USER LIST ROLE HEADER') }}</th>
                    <th class="text-center">{{ _('USER LIST PHONE HEADER') }}</th>
                    <th class="text-center">{{ _('USER LIST ACTIVE HEADER') }}</th>
                    <th class="text-center">{{ _('USER LIST ACTIONS HEADER') }}</th>
                 </tr>
            </thead>
            <tbody>
            {% for user in page.items %}
                <tr>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.phone }}</td>
                    <td class="text-center">
                        {% if user.active %}
                            <span class="label label-success">{{ _('USER LIST ACTIVE LABEL') }}</span>
                        {% else %}
                            <span class="label label-danger">{{ _('USER LIST INACTIVE LABEL') }}</span>
                        {% endif %}
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">
                                <i class="fa fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" aria-labelledby="dLabel">
                                <li>{{ acl_link(['controller': 'user', 'action': 'edit', user.id], '<i class="fa fa-pencil"></i> ' ~ _('USER LIST EDIT ACTION LABEL')) }}</li>
                                <li>{{ acl_link(['controller': 'user', 'action': 'deactivate', user.id], '<i class="fa fa-remove"></i> ' ~ _('USER LIST DEACTIVATE ACTION LABEL')) }}</li>
                                <li>{{ acl_link(['controller': 'user', 'action': 'reactivate', user.id], '<i class="fa fa-check"></i> ' ~ _('USER LIST REACTIVATE ACTION LABEL')) }}</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {% else %}
                <tr>
                    <td colspan="99">{{ _('USER LIST NO USERS MESSAGE') }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        {{ partial('_pagination', ['paginator': page]) }}
    </div>
</div>




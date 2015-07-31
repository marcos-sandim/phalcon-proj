<div class="box">
    <div class="box-header">
        <!--<h3 class="panel-title">Panel title</h3> -->
        {{ acl_link(['controller': 'group', 'action': 'create'], '<i class="fa fa-plus"></i> ' ~ _('GROUP LIST CREATE ACTION LABEL'), ['class': 'btn btn-success btn-xs pull-right']) }}
        <div class="clearfix"></div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-bordered table-hover no-border-bottom">
            <thead>
                <tr>
                    <th class="text-center">{{ _('GROUP LIST NAME HEADER') }}</th>
                    <th class="text-center">{{ _('GROUP LIST IS ADMIN HEADER') }}</th>
                    <th class="text-center">{{ _('GROUP LIST ACTIVE HEADER') }}</th>
                    <th class="text-center fixed-width-50">{{ _('GROUP LIST ACTIONS HEADER') }}</th>
                 </tr>
            </thead>
            <tbody>
            {% for group in page.items %}
                <tr>
                    <td>{{ group.name }}</td>
                    <td class="text-center">
                        {% if group.is_admin %}
                            <span class="label label-success">{{ _('YES') }}</span>
                        {% else %}
                            <span class="label label-danger">{{ _('NO') }}</span>
                        {% endif %}
                    </td>
                    <td class="text-center">
                        {% if group.active %}
                            <span class="label label-success">{{ _('YES') }}</span>
                        {% else %}
                            <span class="label label-danger">{{ _('NO') }}</span>
                        {% endif %}
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">
                                <i class="fa fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" aria-labelledby="dLabel">
                                <li>{{ acl_link(['controller': 'group', 'action': 'edit', group.id], '<i class="fa fa-pencil"></i> ' ~ _('GROUP LIST EDIT ACTION LABEL')) }}</li>
                                <li>{{ acl_link(['controller': 'group', 'action': 'deactivate', group.id], '<i class="fa fa-remove"></i> ' ~ _('GROUP LIST DEACTIVATE ACTION LABEL')) }}</li>
                                <li>{{ acl_link(['controller': 'group', 'action': 'reactivate', group.id], '<i class="fa fa-check"></i> ' ~ _('GROUP LIST REACTIVATE ACTION LABEL')) }}</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {% else %}
                <tr>
                    <td colspan="99">{{ _('GROUP LIST NO GROUPS MESSAGE') }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        {{ partial('_pagination', ['paginator': page]) }}
    </div>
</div>




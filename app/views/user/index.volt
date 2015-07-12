{{ content() }}

<div align="right">
    {{ link_to('/user/create', '<i class="fa fa-plus"></i> Create user', 'class': 'btn btn-success') }}
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Active</th>
                <th>Actions</th>
             </tr>
        </thead>
        <tbody>
        {% for user in page.items %}
            <tr>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role }}</td>
                <td>{{ user.phone }}</td>
                <td>{{ user.active }}</td>
                <td>
                    {{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil"></i> Edit', "class": "btn btn-default") }}
                    {{ link_to("users/delete/" ~ user.id, '<i class="icon-remove"></i> Delete', "class": "btn btn-danger") }}
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan="99">No users</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
</div>
<table>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("user/search", "First") }}</td>
                        <td>{{ link_to("user/search?page=" ~ page.before, "Previous") }}</td>
                        <td>{{ link_to("user/search?page=" ~ page.next, "Next") }}</td>
                        <td>{{ link_to("user/search?page=" ~ page.last, "Last") }}</td>
                        <td> {{page.current ~ '/' ~ page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

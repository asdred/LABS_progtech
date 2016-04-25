<div>
    <div>
        <h2>Организации</h2>
    </div>
    <div>
        {{ link_to("organization/new", "Создать", "class": "btn btn-primary") }}
    </div>
</div>

{% for organizations in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th class="hidden">id</th>
            <th>Название</th>
            <th>Адрес</th>
        </tr>
    </thead>
{% endif %}
{% if organizations.delete == 0 %}
    <tbody>
        <tr>
            <td class="hidden">{{ organizations.id }}</td>
            <td>{{ organizations.name }}</td>
            <td>{{ organizations.address }}</td>
            <td width="7%">{{ link_to("organization/edit/" ~ organizations.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("organization/delete/" ~ organizations.id, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% endif %}
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("organization/index/", '<i class="icon-fast-backward"></i> Первая', "class": "btn btn-default") }}
                    {{ link_to("organization/index/" ~ page.before, '<i class="icon-step-backward"></i> Предыдущая', "class": "btn btn-default") }}
                    {{ link_to("organization/index/" ~ page.next, '<i class="icon-step-forward"></i> Следующая', "class": "btn btn-default") }}
                    {{ link_to("organization/index/" ~ page.last, '<i class="icon-fast-forward"></i> Последняя', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No companies are recorded
{% endfor %}



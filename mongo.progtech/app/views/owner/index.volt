<div>
    <div>
        <h2>Владельцы</h2>
    </div>
    <div>
        {{ link_to("owner/new", "Создать", "class": "btn btn-primary") }}
    </div>
</div>

{% for owners in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" id="table-info" align="center">
    <thead>
        <tr>
            <th class="hidden">id</th>
            <th>И.Фамилия</th>
            <th colspan="2"></th>
        </tr>
    </thead>
{% endif %}
{% if owners.del == 0 %}
    <tbody>
        <tr>
            <td class="hidden">{{ owners.id }}</td>
            <td>{{ owners.name }}</td>
            <td width="7%">{{ link_to("owner/edit/" ~ owners.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("owner/delete/" ~ owners.id, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% endif %}
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("owner/index/", '<i class="icon-fast-backward"></i> Первая', "class": "btn btn-default") }}
                    {{ link_to("owner/index/" ~ page.before, '<i class="icon-step-backward"></i> Предыдущая', "class": "btn btn-default") }}
                    {{ link_to("owner/index/" ~ page.next, '<i class="icon-step-forward"></i> Следующая', "class": "btn btn-default") }}
                    {{ link_to("owner/index/" ~ page.last, '<i class="icon-fast-forward"></i> Последняя', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{{ link_to("export/index/owner", "Экспорт", "class": "btn btn-primary") }}
{% endif %}
{% else %}
    No companies are recorded
{% endfor %}


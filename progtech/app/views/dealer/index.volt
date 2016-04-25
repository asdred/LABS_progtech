<div>
    <div>
        <h2>Диллеры</h2>
    </div>
    <div>
        {{ link_to("dealer/new", "Создать", "class": "btn btn-primary") }}
    </div>
</div>

{% for dealers in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th class="hidden">id</th>
            <th>Название</th>
        </tr>
    </thead>
{% endif %}
{% if dealers.delete == 0 %}
    <tbody>
        <tr>
            <td class="hidden">{{ dealers.id }}</td>
            <td>{{ dealers.name }}</td>
            <td width="7%">{{ link_to("dealer/edit/" ~ dealers.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("dealer/delete/" ~ dealers.id, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% endif %}
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("dealer/index/", '<i class="icon-fast-backward"></i> Первая', "class": "btn btn-default") }}
                    {{ link_to("dealer/index/" ~ page.before, '<i class="icon-step-backward"></i> Предыдущая', "class": "btn btn-default") }}
                    {{ link_to("dealer/index/" ~ page.next, '<i class="icon-step-forward"></i> Следующая', "class": "btn btn-default") }}
                    {{ link_to("dealer/index/" ~ page.last, '<i class="icon-fast-forward"></i> Последняя', "class": "btn btn-default") }}
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
<div>
    <div>
        <h2>Склады</h2>
    </div>
    <div>
        {{ link_to("store/new", "Создать", "class": "btn btn-primary") }}
    </div>
</div>

{% for store in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" id="table-info" align="center">
    <thead>
        <tr>
            <th class="hidden">id</th>
            <th>Владелец</th>
            <th>Название</th>
            <th colspan="2"></th>
        </tr>
    </thead>
{% endif %}
{% if store.del == 0 %}
    <tbody>
        <tr>
            <?php $owner = Owner::findFirst(array(array("id" => (int)$store->owner_id)))->name; ?>
            <td class="hidden">{{ store.id }}</td>
            <td>{{ owner }}</td>
            <td>{{ store.name }}</td>
            <td width="7%">{{ link_to("store/edit/" ~ store.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("store/delete/" ~ store.id, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% endif %}
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("store/index/", '<i class="icon-fast-left"></i> Первая', "class": "btn btn-default") }}
                    {{ link_to("store/index/" ~ page.before, '<i class="icon-step-backward"></i> Предыдущая', "class": "btn btn-default") }}
                    {{ link_to("store/index/" ~ page.next, '<i class="icon-step-forward"></i> Следующая', "class": "btn btn-default") }}
                    {{ link_to("store/index/" ~ page.last, '<i class="icon-fast-forward"></i> Последняя', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{{ link_to("export/index/store", "Экспорт", "class": "btn btn-primary") }}
{% endif %}
{% else %}
    No companies are recorded
{% endfor %}


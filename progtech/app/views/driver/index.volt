<div>
    <div>
        <h2>Водители {{ status }}</h2>
    </div>
    <div>
        <div style="text-align: left">
            {{ form("driver/index") }}
                <input type="radio" name="filter" value="maxExp">Наиболее опытные</inpu><br>
                <input type="radio" name="filter" value="minExp">Наименее опытные</inpu><br>
                <input type="radio" name="filter" value="maxSal">Наиболее оплачиваемые</inpu><br>
                <input type="radio" name="filter" value="minSal">Наименее оплачиваемые</inpu><br>
                {{ submit_button("Фильтр", "class": "btn btn-primary") }}
            </form>
        </div>
        {{ link_to("driver/new", "Создать", "class": "btn btn-primary") }}
    </div>
</div>

{% for drivers in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" id="table-info" align="center">
    <thead>
        <tr>
            <th class="hidden">id</th>
            <th>И.Фамилия</th>
            <th>Стаж</th>
            <th>Зарплата</th>
            <th colspan="2"></th>
        </tr>
    </thead>
{% endif %}
{% if drivers.del == 0 %}
    <tbody>
        <tr>
            <td class="hidden">{{ drivers.id }}</td>
            <td>{{ drivers.name }}</td>
            <td>{{ drivers.experience }}</td>
            <td>{{ drivers.salary }}</td>
            <td width="7%">{{ link_to("driver/edit/" ~ drivers.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("driver/delete/" ~ drivers.id, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% endif %}
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("driver/index/", '<i class="icon-fast-backward"></i> Первая', "class": "btn btn-default") }}
                    {{ link_to("driver/index/" ~ page.before, '<i class="icon-step-backward"></i> Предыдущая', "class": "btn btn-default") }}
                    {{ link_to("driver/index/" ~ page.next, '<i class="icon-step-forward"></i> Следующая', "class": "btn btn-default") }}
                    {{ link_to("driver/index/" ~ page.last, '<i class="icon-fast-forward"></i> Последняя', "class": "btn btn-default") }}
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



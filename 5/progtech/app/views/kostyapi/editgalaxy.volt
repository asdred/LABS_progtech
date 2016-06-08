
<form method="post" action="/kostyapi/editgalaxy">
    <input style="margin-bottom: 1em" name="id" type="hidden" value="{{ out.id }}"><br>
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" value="{{ out.name }}" class="form-control"><br>
    <label for="size">Размер</label>
    <input style="margin-bottom: 1em" name="size" type="text" value="{{ out.size }}" class="form-control"><br>
    <label for="cluster">Кластер</label>
    <select name="cluster" class="form-control">
        {% for cluster_list in clusters %}
           {% for cluster in cluster_list.data %}
                {% if cluster.name != out.cluster %}
                    <option>{{ cluster.name }}</option>
                {% else %}
                    <option selected>{{ cluster.name }}</option>
                {% endif %}
            {% endfor %}
        {% endfor %}
    </select><br>
    <label for="type">Тип галактики</label>
    <select name="type" class="form-control">
        {% for type_list in types %}
            {% for type in type_list.data %}
                {% if type.name != out.type %}
                    <option>{{ type.name }}</option>
                {% else %}
                    <option selected>{{ type.name }}</option>
                {% endif %}
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>

<form method="post" action="/kostyapi/creategalaxy">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="size">Размер</label>
    <input style="margin-bottom: 1em" name="size" type="text" class="form-control"><br>
    <label for="cluster">Кластер</label>
    <select name="cluster" class="form-control">
        {% for cluster_list in clusters %}
           {% for cluster in cluster_list.data %}
            <option>{{ cluster.name }}</option>
           {% endfor %}
        {% endfor %}
    </select><br>
    <label for="type">Тип галактики</label>
    <select name="type" class="form-control">
        {% for type_list in types %}
            {% for type in type_list.data %}
            <option>{{ type.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
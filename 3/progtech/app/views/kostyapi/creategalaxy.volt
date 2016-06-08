
<form method="post" action="/kostyapi/creategalaxy">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="size">Размер</label>
    <input style="margin-bottom: 1em" name="size" type="text" class="form-control"><br>
    <label for="cluster">Кластер</label>
    <select name="cluster" class="form-control">
        {% for cluster in  clusters %}
            <option>{{ cluster.name }}</option>
        {% endfor %}
    </select><br>
    <label for="type">Тип галактики</label>
    <select name="type" class="form-control">
        {% for type in types %}
            <option>{{ type.name }}</option>
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
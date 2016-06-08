<form method="post" action="/kostyapi/createblackhole">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="weight">Вес</label>
    <input style="margin-bottom: 1em" name="weight" type="text" class="form-control"><br>
    <label for="size">Возраст</label>
    <input style="margin-bottom: 1em" name="age" type="text" class="form-control"><br>
    <label for="type">Галактика</label>
    <select name="galaxy" class="form-control">
        {% for galaxy_list in  galaxys %}
            {% for galaxy in galaxy_list.data %}
            <option>{{ galaxy.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <label for="type">Тип чёрной дыры</label>
    <select name="type" class="form-control">
        {% for type_list in types %}
            {% for type in type_list.data %}
            <option>{{ type.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
<form method="post" action="/kostyapi/editblackhole">
    <input style="margin-bottom: 1em" name="id" type="hidden" value="{{ out.id }}"><br>
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" value="{{ out.name }}" class="form-control"><br>
    <label for="weight">Вес</label>
    <input style="margin-bottom: 1em" name="weight" type="text" value="{{ out.weight }}" class="form-control"><br>
    <label for="size">Возраст</label>
    <input style="margin-bottom: 1em" name="age" type="text" value="{{ out.age }}" class="form-control"><br>
    <label for="type">Тип чёрной дыры</label>
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
    <label for="galaxy">Галактика</label>
    <select name="galaxy" class="form-control">
        {% for galaxy_list in  galaxys %}
            {% for galaxy in galaxy_list.data %}
                {% if galaxy.name != out.galaxy %}
                    <option>{{ galaxy.name }}</option>
                {% else %}
                    <option selected>{{ galaxy.name }}</option>
                {% endif %}
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
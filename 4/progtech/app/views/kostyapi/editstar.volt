
<form method="post" action="/kostyapi/editstar">
    <input style="margin-bottom: 1em" name="id" type="hidden" value="{{ out.id }}"><br>
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" value="{{ out.name }}" class="form-control"><br>
    <label for="size">Возраст</label>
    <input style="margin-bottom: 1em" name="age" type="text" value="{{ out.age }}" class="form-control"><br>
    <label for="weight">Вес</label>
    <input style="margin-bottom: 1em" name="weight" type="text" value="{{ out.weight }}" class="form-control"><br>
    <label for="solar_system">Система</label>
    <select name="solar_system" class="form-control">
        {% for system_list in  solarsystems %}
            {% for system in system_list.data %}
                {% if system.name != out.solar_system %}
                    <option>{{ system.name }}</option>
                {% else %}
                    <option selected>{{ system.name }}</option>
                {% endif %}
            {% endfor %}
        {% endfor %}
    </select><br>
    <label for="type">Тип звезды</label>
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
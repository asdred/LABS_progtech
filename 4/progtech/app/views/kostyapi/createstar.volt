
<form method="post" action="/kostyapi/createstar">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="size">Возраст</label>
    <input style="margin-bottom: 1em" name="age" type="text" class="form-control"><br>
    <label for="weight">Вес</label>
    <input style="margin-bottom: 1em" name="weight" type="text" class="form-control"><br>
    <label for="solar_system">Система</label>
    <select name="solar_system" class="form-control">
        {% for system_list in  solarsystems %}
            {% for system in system_list.data %}
            <option>{{ system.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <label for="type">Тип звезды</label>
    <select name="type" class="form-control">
        {% for type_list in types %}
            {% for type in type_list.data %}
            <option>{{ type.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
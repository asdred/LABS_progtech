
<form method="post" action="/kostyapi/createstar">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="size">Возраст</label>
    <input style="margin-bottom: 1em" name="age" type="text" class="form-control"><br>
    <label for="weight">Вес</label>
    <input style="margin-bottom: 1em" name="weight" type="text" class="form-control"><br>
    <label for="solar_system">Система</label>
    <select name="solar_system" class="form-control">
        {% for system in  solarsystems %}
            <option>{{ system.name }}</option>
        {% endfor %}
    </select><br>
    <label for="type">Тип звезды</label>
    <select name="type" class="form-control">
        {% for type in types %}
            <option>{{ type.name }}</option>
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
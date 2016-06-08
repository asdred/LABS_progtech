<form method="post" action="/kostyapi/createsolarsystem">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="galaxy">Галактика</label>
    <select name="galaxy" class="form-control">
        {% for galaxy_list in  galaxys %}
            {% for galaxy in galaxy_list.data %}
            <option>{{ galaxy.name }}</option>
            {% endfor %}
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
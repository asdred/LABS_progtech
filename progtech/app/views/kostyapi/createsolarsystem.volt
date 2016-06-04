<form method="post" action="/kostyapi/createsolarsystem">
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" class="form-control"><br>
    <label for="galaxy">Галактика</label>
    <select name="galaxy" class="form-control">
        {% for galaxy in  galaxys %}
            <option>{{ galaxy.name }}</option>
        {% endfor %}
    </select><br>
    <input type="submit">
</form>
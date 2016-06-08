
<form method="post" action="/kostyapi/editsolarsystem">
    <input style="margin-bottom: 1em" name="id" type="hidden" value="{{ out.id }}"><br>
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" value="{{ out.name }}"  class="form-control"><br>
    <label for="galaxy">Галактика</label>
    <select name="galaxy"  class="form-control">
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
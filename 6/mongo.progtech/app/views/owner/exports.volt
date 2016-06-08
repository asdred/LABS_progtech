{% for index in 1..parts %}
    {{ link_to("owner/export", "Экспорт " ~ index, "class": "btn btn-primary") }}</br>
{% endfor %}
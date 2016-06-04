<!-- СТАТУС:"{{ status }}"<br> -->
<form method="post" action="/kostyapi/editcluster">
    <input style="margin-bottom: 1em" name="id" type="hidden" value="{{ out.id }}"><br>
    <label for="name">Название</label>
    <input style="margin-bottom: 1em" name="name" type="text" value="{{ out.name }}" class="form-control"><br>
    <label for="size">Размер</label>
    <input style="margin-bottom: 1em" name="size" type="text" value="{{ out.size }}" class="form-control"><br>
    <input type="submit">
</form>
{{ link_to("kostyapi/creategalaxy/", 'Создать', "class": "btn btn-primary") }}
<table class="table table-bordered table-striped">
    <tr>
        <td class="table_header hidden">id</td>
        <td class="table_header">Название</td>
        <td class="table_header">Размер</td>
        <td class="table_header">Тип</td>
        <td class="table_header">Кластер</td>
        <td colspan="2"></td>
    </tr>
<?php
    foreach ($out->data as $data) {
?>
    <tr>
        <td class="table_body hidden"><?=$data->id?></td>
        <td class="table_body"><?=$data->name?></td>
        <td class="table_body"><?=$data->size?></td>
        <td class="table_body"><?=$data->type?></td>
        <td class="table_body"><?=$data->cluster?></td>
        <td width="7%">{{ link_to("kostyapi/editgalaxy/" ~ data.id, '<i class="glyphicon glyphicon-edit"></i> Изменить', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("kostyapi/deletegalaxy/" ~ data.name, '<i class="glyphicon glyphicon-remove"></i> Удалить', "class": "btn btn-default") }}</td>
    </tr>	
<?php
    }
?>
    <tr>
        <td colspan="7" align="right">
            <div class="btn-group">
                <form action="/Kostyapi/select" method="post">
                    <input type="hidden" name="table" value="галактика">
                    <button class="btn btn-default" type="submit" name="page" value="1"><i class="icon-fast-backward"></i>Первая</button>
                    <button class="btn btn-default" type="submit" name="page" value="{{ current_page }}"><i class="icon-step-backward"></i>Предыдущая</button>
                    <button class="btn btn-default"type="submit" name="page" value="{{ current_page + 1 }}"><i class="icon-step-backward"></i>Следующая</button>
                    <button class="btn btn-default" type="submit" name="page" value="{{ out.count_pages }}"><i class="icon-fast-forward"></i>Последняя</button>
                    <span class="help-inline">{{ current_page }}/{{ out.count_pages }}</span>
                </form>
            </div>
        </td>
    </tr>
</table>
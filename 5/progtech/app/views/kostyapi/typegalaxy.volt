<table class="table table-bordered table-striped">
    <tr>
        <td class="table_header hidden">id</td>
        <td class="table_header">Название</td>
        <td class="table_header">Описание</td>
        <td colspan="2"></td>
    </tr>
<?php
    foreach ($out->data as $data) {
?>
    <tr>
        <td class="table_body hidden"><?=$data->id?></td>
        <td class="table_body"><?=$data->name?></td>
        <td class="table_body"><?=$data->description?></td>
    </tr>	
<?php
    }
?>
</table>
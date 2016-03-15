<!DOCTYPE html!>
<html>
    <head>
        <meta charset="utf-8">
        <title>ТП. Лабораторная 1.</title>
        <link type="text/css" rel="stylesheet" href="css/table.css"/>
        <link type="text/css" rel="stylesheet" href="css/index.css"/>
    </head>
    <body>
<?php 
    
    echo '<table class="simple-little-table">';
    echo '<thead>';
    echo '<tr>';

    // ПОДКЛЮЧЕНИЕ ЧЕРЕЗ PDO, позволяет избежать SQL-Инъекции
    //Данные доступа
    try {
        $user = 'postgres';  
        $pass = 'admin';  
        $host = 'localhost';  
        $db='cars';  
        $dbh = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    } catch (PDOException $e) {  
        echo "Error!: " . $e->getMessage() . "<br/>";  
        die();  
    }
    
    $row_count = 0;
        
    $table = $_GET['t'];
    $page = $_GET['p'];
        
    echo '<script>';
    echo 'function count(obj) {';
    echo 'location.assign("http://pt.lab1.dev/form_update.php?t=' . $table . '&i=" + obj.cells[0].innerText);';
    echo '}';
    echo '</script>';

    $columns = $dbh->query("SELECT column_name FROM information_schema.columns WHERE table_name = '{$table}'");
    $columns->setFetchMode(PDO::FETCH_ASSOC);
    
    $columns_array = array();

    while($col = $columns->fetch()) {
        if ($col['column_name'] == 'deleted') continue;
        array_push($columns_array, $col['column_name']);
        echo "<th>{$col['column_name']}</th>";
    }
    
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // отладка
    //echo "SELECT " . implode(', ',$columns_array) . " FROM {$table}";
    
    $sth = $dbh->query("SELECT " . implode(', ',$columns_array) . " FROM {$table} WHERE deleted=false LIMIT 5 OFFSET " . (($page * 5) - 5));
    $sth->setFetchMode(PDO::FETCH_ASSOC);  
  
    while($row = $sth->fetch()) {
        echo '<tr onclick="count(this)">';
        $row_count++;
        foreach ($columns_array as $column_name) {
            echo '<td>' . $row[$column_name] . '</td>';
        }
        echo '</tr>';  
    }

    // Закрытие соединений
    $dbh = null;

    echo '</tbody>';
    echo '</table>';

    /* 
    // open a connection to the database server
    $connection = pg_connect ("host=$host dbname=$db user=$user
    password=$pass") or die("Could not open connection to database server");
    
    // anti SQL-injection
    $query = "SELECT * FROM " . $table;

    echo ' ' . $query;
    echo ' ' . pg_escape_string($query);
        
    $result = pg_query($connection, $query) or die("Error in query: $query.
    " . pg_last_error($connection));

    */ /*
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>id</th>';
    echo '<th>name</th>';
    echo '<th>country</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
  
    //  
    while($data = pg_fetch_array($result)) { 
        echo '<tr>';
        echo '<td>' . $data['id'] . '</td>';
        echo '<td>' . $data['name'] . '</td>';
        echo '<td>' . $data['country'] . '</td>';
        echo '</tr>';
    }
  
    echo '</tbody>';
  echo '</table>';

    pg_close($connection);
    
    */
    echo '<a href="http://pt.lab1.dev/form_insert.php?t=' . $table . '">';
    echo '<button class="submit" type="submit" name="' . $table . '"> Добавить </button><br>';
    echo '</a>';
    
    echo '<nav id="table-navigation">';
    if ($page > 1) {    
        echo '<a href="http://pt.lab1.dev/table.php?t=' . $table . '&p=' . ($page - 1) . '">';
        echo '<button class=submit>Назад</button>';
        echo '</a>';
    }
    
    if ($row_count == 5) {
        echo '<a href="http://pt.lab1.dev/table.php?t=' . $table . '&p=' . ($page + 1) . '">';
        echo '<button class=submit>Вперёд</button>';
        echo '</a>';
    }
    echo '</nav>';
        
?>
    </body>
</html>
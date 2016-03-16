<!DOCTYPE html!>
<html>
    <head>
        <meta charset="utf-8">
        <title>ТП. Лабораторная 1.</title>
        <link type="text/css" rel="stylesheet" href="css/table.css"/>
        <link type="text/css" rel="stylesheet" href="css/index.css"/>
    </head>
    <body> 
    
    <table class="simple-little-table">
        <thead>
            <tr>
                
    <?php
                
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
    
    // Счётчик строк для постраничного вывода
    $row_count = 0;
        
    $table = $_GET['t'];
    $page = $_GET['p']; 
        
    ?>
        
    <script>
        function count(obj) {
            location.assign("http://pt.lab1.dev/form_update.php?t=<?php echo $table ?>&i=" + obj.cells[0].innerText);
        }
    </script>

    <?php
    
    // Просчёт кол-ва страниц
    
    $rows_count_query = $dbh->query("SELECT Count(id) FROM {$table} WHERE deleted = false");
    $rows_count_query->setFetchMode(PDO::FETCH_ASSOC);
    $rows_count = $rows_count_query->fetch()['count'];
    $page_count = $rows_count / 5; 
    
    $columns = $dbh->query("SELECT column_name FROM information_schema.columns WHERE table_name = '{$table}'");
    $columns->setFetchMode(PDO::FETCH_ASSOC);
    
    $columns_array = array();

    while($col = $columns->fetch()) {
        //if ($col['column_name'] == 'deleted') continue;
        array_push($columns_array, $col['column_name']);
        
        if (strpos($col['column_name'], 'id') !== false or strpos($col['column_name'], 'deleted') !== false) {
                echo '<th hidden="true">' . $col['column_name'] . '</th>';
            } else {
                echo '<th>' . $col['column_name'] . '</th>';
            }
    }
                            
    ?>
    
            </tr>
        </thead>
    <tbody>
        
    <?php

    // отладка
    //echo "SELECT " . implode(', ',$columns_array) . " FROM {$table}";
    
    $sth = $dbh->query("SELECT " . implode(', ',$columns_array) . " FROM {$table} WHERE deleted=false LIMIT 5 OFFSET " . (($page * 5) - 5));
    $sth->setFetchMode(PDO::FETCH_ASSOC);  
  
    while($row = $sth->fetch()) {
        echo '<tr onclick="count(this)">';
        
        foreach ($columns_array as $column_name) {
            if (strpos($column_name, 'id') !== false or strpos($column_name, 'deleted') !== false) {
                echo '<td hidden="true">' . $row[$column_name] . '</td>';
            } else {
                echo '<td>' . $row[$column_name] . '</td>';
            }
        }
        
        echo '</tr>';  
    }

    // Закрытие соединений
    $dbh = null;
        
    ?>

    </tbody>
    </table>
        
    <!--
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
    -->
    
        <a href="http://pt.lab1.dev/form_insert.php?t=<?php echo $table ?>">
            <button class="submit" type="submit" name="<?php echo $table ?>">Добавить</button><br>
        </a>
        <nav id="table-navigation">
        
    <?php
    
    if ($page > 1) {    
        echo '<a href="http://pt.lab1.dev/table.php?t=' . $table . '&p=' . ($page - 1) . '">';
        echo '<button class=submit>Назад</button>';
        echo '</a>';
    }
    
    if ($page < $page_count) {
        echo '<a href="http://pt.lab1.dev/table.php?t=' . $table . '&p=' . ($page + 1) . '">';
        echo '<button class=submit>Вперёд</button>';
        echo '</a>';
    }
       
    ?>
        
        </nav>    
    </body>
</html>
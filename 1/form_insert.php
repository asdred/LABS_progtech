<!DOCTYPE html>
<html>
    <head>
        <title>lab1</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="css/index.css"/>
        <link type="text/css" rel="stylesheet" href="css/form.css"/>
    </head>
    <body>
    <nav id="menu">
    <a href="http://pt.lab1.dev/table.php?t=<?php echo $_GET['t'] ?>&p=1">
        <button class="submit">Назад</button>
    </a>
    </nav>
        <div id="form">
            <form class="insert_form" action="insert.php" method="post">
                <ul>
                    
                <?php
                    
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
                    
                $table = $_GET['t'];

                $columns = $dbh->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '{$table}'");
                $columns->setFetchMode(PDO::FETCH_ASSOC);

                $columns_array = array();
                $types_array = array();

                while($col = $columns->fetch()) {
                    
                    if($col['column_name'] == 'id' or $col['column_name'] == 'deleted') continue;
                    
                    array_push($columns_array, $col['column_name']);
                    array_push($types_array, $col['data_type']);

                    if($col['data_type'] == 'character varying') $input_type = 'text';
                    else if ($col['data_type'] == 'integer') $input_type = 'number';
                    
                    // Начало не универсального кода
                    
                    if ($col['column_name'] != 'dealer_id') {
                        echo '<li>';
                        echo '<label for="' . $col['column_name'] . '">' . $col['column_name'] . '</label>';
                        echo '<input type="' . $input_type . '" name="' . $col['column_name'] . '" placeholder="' . $col['column_name']. '" required/>';
                        echo '<span class="form_hint">Proper format "' . $col['data_type'] . '"</span>';
                        echo '</li>';
                    } else {
                        $dealers = $dbh->query("SELECT id, name FROM dealers WHERE deleted=false");
                        $dealers->setFetchMode(PDO::FETCH_ASSOC);
                        
                        echo '<li>';
                        echo '<label for="dealer_id">dealer</label>';
                        echo '<select name="dealer_id" required/>';
                        while($dealer = $dealers->fetch()) {
                            echo '<option value="' . $dealer['id'] . '">' . $dealer['name'] . '</option>';
                        }
                        echo '</select>';
                        echo '<span class="form_hint">Select one item!</span>';
                        echo '</li>';
                    }
                    
                    // Конец не универсального кода
                }
            
                ?>
                    <li>
                        <button class="submit" type="submit" name="t" value="<?php echo $table ?>">Добавить</button>
                    </li>
                </ul>
            </form>
        </div>
    </body>
</html>
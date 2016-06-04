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

        $table = $_POST['t'];
        $id = $_POST['id']; 
            
        $columns = $dbh->query("SELECT column_name FROM information_schema.columns WHERE table_name = '{$table}'");
        $columns->setFetchMode(PDO::FETCH_ASSOC);

        $set_columns_array = array();
        $values_array = array();

        while($col = $columns->fetch()) {
            
            if ($col['column_name'] == 'id') continue;
            
            array_push($set_columns_array, $col['column_name'] . '=' . '?');
            
            if (isset($_POST[ $col['column_name'] ])) {
                array_push($values_array, $_POST[ $col['column_name'] ]);
            } else {
                array_push($values_array, 'false');
            }
        }

        $query = "UPDATE " . $table . " SET " . implode(', ',$set_columns_array) . " WHERE id=" . $id . ";";

        $sth = $dbh->prepare($query);  
        $sth->execute($values_array);

        header("Location: http://pt.lab1.dev/table.php?t=" . $table . "&p=1");
?>
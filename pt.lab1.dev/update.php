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
            
            if ($col['column_name'] == 'id' or $col['column_name'] == 'deleted') continue;
            
            array_push($set_columns_array, $col['column_name'] . '=' . '?');
            array_push($values_array, $_POST[ $col['column_name'] ]);
        }

        /*
        echo '<br>';
        print_r($columns_array);
        echo '<br>';
        print_r($values_array);
        echo '<br>';
        */

        // UPDATE cars SET model=?, SET year=?, SET dealer_id=? WHERE id=3;

        $query = "UPDATE " . $table . " SET " . implode(', ',$set_columns_array) . " WHERE id=" . $id . ";";

        //print_r($values_array);
        echo $query;

        $sth = $dbh->prepare($query);  
        $sth->execute($values_array);

        header("Location: http://pt.lab1.dev/table.php?t=" . $table);
?>
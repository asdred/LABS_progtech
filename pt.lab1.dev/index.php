<!DOCTYPE html!>
<html>
    <head>
        <meta charset="utf-8">
        <title>ТП. Лабораторная 1.</title>
        <link type="text/css" rel="stylesheet" href="css/index.css"/>
    </head>
    <body>
        <nav id="menu">
            
        <?php 
        
        $connection = pg_connect ("host=localhost dbname=cars user=postgres password=admin") or die("Could not open connection to database server");
        
        $query = "select relname from pg_stat_user_tables order by relname;";
        $result = pg_query($connection, $query) or die("Error in query: $query." . pg_last_error($connection));
            
        $tables_array = array();    
            
        while($data = pg_fetch_array($result)) { ?>
            <a href="http://pt.lab1.dev/table.php?t=<?php echo $data['relname'] ?>&p=1" >
            <button class="submit" type="submit" name="<?php echo $data['relname'] ?>"><?php echo $data['relname'] ?></button><br>
            </a>
            
            <?php  
            
            array_push($tables_array, $data['relname']);
        }
        pg_close($connection);
        ?>
            
        </nav>
    </body>
</html>
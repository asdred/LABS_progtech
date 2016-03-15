<!DOCTYPE html>
<html>
    <head>
        <title>lab1</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="css/form.css"/>
    </head>
    <body>
        <div id="form">
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
            
                echo '<form class="insert_form" action="update.php" method="post">';
                echo '<ul>';
                
                $table = $_GET['t'];
                $id = $_GET['i'];
                
                $columns = $dbh->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '{$table}'");
                $columns->setFetchMode(PDO::FETCH_ASSOC);
                
                $columns_array = array();
                $types_array = array();

                while($col = $columns->fetch()) {
                    
                    if($col['column_name'] == 'id') {
                        echo '<li>';
                        echo '<input type="hidden" name="id" value="' . $id . '">';
                        echo '</li>';
                        continue;
                    } elseif ($col['column_name'] == 'deleted') continue;
                    
                    array_push($columns_array, $col['column_name']);
                    array_push($types_array, $col['data_type']);

                    if($col['data_type'] == 'character varying') $input_type = 'text';
                    else if ($col['data_type'] == 'integer') $input_type = 'number';

                    echo '<li>';
                    echo '<label for="' . $col['column_name'] . '">' . $col['column_name'] . '</label>';
                    echo '<input id="' . $col['column_name'] . '" type="' . $input_type . '" name="' . $col['column_name'] . '" placeholder="' . $col['column_name']. '" required/>';
                    echo '<span class="form_hint">Proper format "' . $col['data_type'] . '"</span>';
                    echo '</li>';
                }
                
                $values = $dbh->query("SELECT " . implode(', ',$columns_array) . " FROM " . $table . " WHERE id=" . $id);
                $values->setFetchMode(PDO::FETCH_ASSOC);
                
                $val = $values->fetch();
                foreach($columns_array as $column_name) {
                    echo '<script>';
                    echo "document.getElementById('" . $column_name . "').value = '" . $val[ $column_name ] . "';";
                    echo '</script>';
                }
            
                echo '<li>';
                echo '<label for="deleted">Deleted?</label>';
                echo '<input type="checkbox" name="deleted">';
                echo '</li>';
                
                echo '<li>';
                echo '<button class="submit" type="submit" name="t" value="' . $table . '">Изменить</button>';
                echo '</li>';
                
            
            
            ?>
            <!--
                    <li>
                        <label for="table">Таблица:</label>
                        <select id="sel" name="table" onchange="select(this)">
                            <option value="dealers">Диллеры</option>
                            <option value="cars">Автомобили</option>
                        </select>
                    </li>
                    <li id="first">
                        <label for="dealer">Диллер:</label>
                        <input type="text" name="dealer" placeholder="Renault" required/>
                        <span class="form_hint">Proper format "Text"</span>
                    </li>
                    <li id="second">
                        <label for="contry">Страна:</label>
                        <input type="text" name="country" placeholder="France" required/>
                        <span class="form_hint">Proper format "Text"</span>
                    </li>
                    <li>
                        <button class="submit" type="submit" name="add">Добавить</button>
                    </li>
            -->
                </ul>
            </form>
        </div>
    </body>
</html>
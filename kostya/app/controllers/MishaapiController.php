<?php
use Phalcon\Mvc\Controller;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Http\Response;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class MishaapiController extends Controller
{
	private function curvl($table, $page)
	{
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://misha.api/'.$table."/".$page);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		return json_decode(curl_exec($curl));
	}

    public function indexAction()
    {
        
    }

    public function selectAction()
    {
        if ($this->request->isPost() == true) 
        {
        	$validation = new Validation();
        	$validation->add('table', new RegexValidator(array(
               'pattern' => '/[а-я\s]{1,9}/u',
               'message' => 'Выберите правильную таблицу<br />'
            )));
            $validation->add('page', new RegexValidator(array(
               'pattern' => '/[0-9]{1,3}/',
               'message' => 'Введите правильно страницу<br />'
            )));
            $messages = $validation->validate($_POST);
            if (!count($messages)) 
            {
            	if ($this->request->getPost("table") == "машины") {
            		$out = $this->curvl("car", $this->request->getPost("page"));
            		if ($out->status == "Найдено") {
				    	foreach ($out->data as $data) {
				    		?>
				    			<table>
							        <tr>
							            <td class="table_header">Марка</td>
							            <td class="table_header">Модель</td>
							            <td class="table_header">Грузоподъёмность</td>
							            <td class="table_header">Водитель</td>
							            <td class="table_header">Владелец</td>
							            <td class="table_header">Изменить</td>
							            <td class="table_header">Удалить</td>
							        </tr>
							        <?
							            foreach ($data as $date_row) {
											?>
												<tr>
												    <td class="table_body"><?=$date_row->dealer?></td>
												    <td class="table_body"><?=$date_row->model?></td>
												    <td class="table_body"><?=$date_row->capacity?></td>
												    <td class="table_body"><?=$date_row->driver?></td>
												    <td class="table_body"><?=$date_row->owner?></td>
												    <td class="table_body"><a href="http://space.tp/mishaapi/update?id=<?=$date_row->id?>&table=car">Изменить</a></td>
												    <td class="table_body"><a href="http://space.tp/mishaapi/update?id=<?=$date_row->id?>&table=car">Удалить</a></td>
												</tr>
											<?
										}
							        ?>
								</table>
				    		<?
				    	}
				    }
				    else
				    {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "марки автомобилей") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "водители") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "организации") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "владельцы") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "продукты") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "типы продуктов") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "груз") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "магазины") {
            		# code...
            	}
            	elseif ($this->request->getPost("table") == "перевозки") {
            		# code...
            	}
            	else {
            		echo "<p>Ой, что-то пошло не так</p>";
            	}
			    

            }
            else
                foreach ($messages as $message) {
                    echo $message;
                }
        }
        else
            echo "Опаньки, поста то нет";

        $this->view->disable();
    }
}
?>
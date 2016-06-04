<?php
header("Content-Type: text/html; charset=utf-8");
use Phalcon\Mvc\Controller;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Http\Response;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class KostyapiController extends ControllerBase
{   
    
    # по id http://.../Api/idblackhole?id=
    
    // get
    
	private function curvl($table, $page)
	{
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/'.$table."?page=".$page);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		return json_decode(curl_exec($curl));
	}
    
    // get by id
    
    private function curvl_id($table, $id)
	{
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/id'.$table."?id=".$id);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		return json_decode(curl_exec($curl));
	}
    
    // get by name
    
    private function curvl_name($table, $name)
	{
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/name'.$table."?name=".$name);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		return json_decode(curl_exec($curl));
	}
    
    // post

    private function curvl_post($data, $table) 
    { 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/add'.$table); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true); 
        return json_decode(curl_exec($curl)); 
    }
    
    private function curvl_upd($data, $table) 
    { 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/upd'.$table); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true); 
        return json_decode(curl_exec($curl)); 
    }
    
    private function curvl_del($name, $table) 
    { 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://kostya.vh/Api/del'.$table."?name=".$name); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true); 
        return json_decode(curl_exec($curl)); 
    }

    public function indexAction()
    {
        
    }
    
    // SELECT
    
    public function selectAction()
    {
        if ($this->request->isPost() == true) 
        {
            	if ($this->request->getPost("table") == "кластер") 
                {
            		$out = $this->curvl("cluster", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "cluster",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "галактика") {
            		$out = $this->curvl("galaxy", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "galaxy",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "солнечная система") {
            		$out = $this->curvl("solarsystem", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "solarsystem",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "чёрная дыра") {
            		$out = $this->curvl("blackhole", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "blackhole",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "планета") {
            		$out = $this->curvl("planet", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "planet",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "звезда") {
            		$out = $this->curvl("star", $this->request->getPost("page"));
                    
            		if ($out->count_pages >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "star",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "тип галактик") {
            		$out = $this->curvl("typegalaxy", $this->request->getPost("page"));
                    
            		if (count($out) >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "typegalaxy",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "тип чёрных дыр") {
            		$out = $this->curvl("typeblackhole", $this->request->getPost("page"));
                    
            		if (count($out) >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "typeblackhole",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "тип планет") {
            		$out = $this->curvl("typeplanet", $this->request->getPost("page"));
                    
            		if (count($out) >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "typeplanet",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	elseif ($this->request->getPost("table") == "тип звёзд") {
            		$out = $this->curvl("typestar", $this->request->getPost("page"));
                    
            		if (count($out) >= 1) {
                        $this->dispatcher->forward(
                            array(
                                "controller" => "kostyapi",
                                "action"     => "typestar",
                                "params"     => array("out" => $out)
                            )
                        );
				    } else {
				    	echo "Ничего не найдено";
				    }
            	}
            	else {
            		echo "<p>Ой, что-то пошло не так</p>";
            	}

        }
        else
            echo "Опаньки, поста то нет";
    }
    
    public function clusterAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function galaxyAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function solarsystemAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function blackholeAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function planetAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function starAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function typegalaxyAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function typestarAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function typeplanetAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    public function typeblackholeAction() {
        $this->view->out = $this->dispatcher->getParam("out");
        $this->view->current_page = $this->request->isPost("page");
    }
    
    // EDIT
    
    public function editclusterAction($id) {
        
        if (!$this->request->getPost()) {
            
            $this->view->out = $this->curvl_id("cluster", $id)->data;
            
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $size = $this->request->getPost("size");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->size = $size;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name, 
                'size' => $size
            ), "cluster")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function editgalaxyAction($id) {
        
        if (!$this->request->getPost()) {
        
            $this->view->types = $this->curvl("typegalaxy", 1)->data;
            $this->view->clusters = $this->curvl("cluster", 1)->data;
            
            $this->view->out = $this->curvl_id("galaxy", $id)->data;
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $size = $this->request->getPost("size");
            $cluster = $this->request->getPost("cluster");
            $type = $this->request->getPost("type");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->size = $size;
            $this->view->cluster = $cluster;
            $this->view->type = $type;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name, 
                'size' => $size,
                'cluster' => $cluster,
                'type' => $type
            ), "galaxy")->status;
            
            //$cluster = $this->curvl_name("cluster", $cluster);
            //$type = $this->curvl_name("typegalaxy", $cluster);
            
            $this->view->status = $status;
            //$this->view->getname = $getname;
        }
    }
    
    public function editplanetAction($id) {
        
        if (!$this->request->getPost()) {
            
            $this->view->solarsystems = $this->curvl("solarsystem", 1)->data;
            $this->view->types = $this->curvl("typeplanet", 1)->data;
            
            $this->view->out = $this->curvl_id("planet", $id)->data;
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $weight = $this->request->getPost("weight");
            $solar_system = $this->request->getPost("solar_system");
            $type = $this->request->getPost("type");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->weight = $weight;
            $this->view->solar_system = $solar_system;
            $this->view->type = $type;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name, 
                'weight' => $weight,
                'solar_system' => $solar_system,
                'type' => $type
            ), "planet")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function editstarAction($id) {
        
        if (!$this->request->getPost()) {
            
            $this->view->solarsystems = $this->curvl("solarsystem", 1)->data;
            $this->view->types = $this->curvl("typestar", 1)->data;
            
            $this->view->out = $this->curvl_id("star", $id)->data;
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $age = $this->request->getPost("age");
            $weight = $this->request->getPost("weight");
            $solar_system = $this->request->getPost("solar_system");
            $type = $this->request->getPost("type");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->age = $age;
            $this->view->weight = $weight;
            $this->view->solar_system = $solar_system;
            $this->view->type = $type;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name,
                'age' => $age,
                'weight' => $weight,
                'solar_system' => $solar_system,
                'type' => $type
            ), "star")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function editsolarsystemAction($id) {
        
        if (!$this->request->getPost()) {
            
            $this->view->galaxys = $this->curvl("galaxy", 1)->data;
            
            $this->view->out = $this->curvl_id("solarsystem", $id)->data;
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $galaxy = $this->request->getPost("galaxy");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->galaxyy = $galaxy;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name,
                'galaxy' => $galaxy
            ), "solarsystem")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function editblackholeAction($id) {
        
        if (!$this->request->getPost()) {
            
            $this->view->galaxys = $this->curvl("galaxy", 1)->data;
            $this->view->types = $this->curvl("typeblackhole", 1)->data;
            
            $this->view->out = $this->curvl_id("blackhole", $id)->data;
        } else {
            
            $id = $this->request->getPost("id");
            $name = $this->request->getPost("name");
            $galaxy = $this->request->getPost("galaxy");
            $age = $this->request->getPost("age");
            $weight = $this->request->getPost("weight");
            $type = $this->request->getPost("type");
            
            $this->view->id = $id;
            $this->view->name = $name;
            $this->view->galaxyy = $galaxy;
            $this->view->age = $age;
            $this->view->weight = $weight;
            $this->view->type = $type;
            
            $status = $this->curvl_upd(array(
                'id'    => $id,
                'name' => $name,
                'galaxy' => $galaxy,
                'age' => $age,
                'weight' => $weight,
                'type' => $type
            ), "blackhole")->status;
            
            $this->view->status = $status;
        }
    }
    
    // CREATE
    
    public function createclusterAction() {
        
        if ($this->request->getPost()) {
            
            $status = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'size' => $this->request->getPost("size")
            ), "cluster")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function creategalaxyAction() {
        
        $this->view->types = $this->curvl("typegalaxy", 1)->data;
        $this->view->clusters = $this->curvl("cluster", 1)->data;
        
        if ($this->request->getPost()) {
            
            $add = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'size' => $this->request->getPost("size"),
                'type' => $this->request->getPost("type"),
                'cluster' => $this->request->getPost("cluster")
            ), "galaxy")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function createplanetAction() {
        
        $this->view->solarsystems = $this->curvl("solarsystem", 1)->data;
        $this->view->types = $this->curvl("typeplanet", 1)->data;
        
        if ($this->request->getPost()) {
            
            $add = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'weight' => $this->request->getPost("weight"),
                'solar_system' => $this->request->getPost("solar_system"), 
                'type' => $this->request->getPost("type")
            ), "planet")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function createstarAction() {
        
        $this->view->solarsystems = $this->curvl("solarsystem", 1)->data;
        $this->view->types = $this->curvl("typestar", 1)->data;
        
        if ($this->request->getPost()) {
            
            $add = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'age' => $this->request->getPost("age"),
                'weight' => $this->request->getPost("weight"),
                'solar_system' => $this->request->getPost("solar_system"),
                'type' => $this->request->getPost("type")
            ), "star")->status;
            
            $this->view->status = $status;
        }
    }
    
    public function createsolarsystemAction() {
        
        $this->view->galaxys = $this->curvl("galaxy", 1)->data;
        
        if ($this->request->getPost()) {
            
            $add = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'galaxy' => $this->request->getPost("galaxy")
            ), "solarsystem");
            
            $this->view->status = $status;
        }
    }
    
    public function createblackholeAction() {
        
        $this->view->galaxys = $this->curvl("galaxy", 1)->data;
        $this->view->types = $this->curvl("typeblackhole", 1)->data;
        
        if ($this->request->getPost()) {
            
            $add = $this->curvl_post(array(
                'name' => $this->request->getPost("name"), 
                'weight' => $this->request->getPost("weight"),
                'type' => $this->request->getPost("type"),
                'age' => $this->request->getPost("age"),
                'galaxy' => $this->request->getPost("galaxy")
            ), "blackhole")->status;
            
            $this->view->status = $status;
        }
    }
    
    // DELETE
    
    public function deleteclusterAction($name) {
        
        $del = $this->curvl_del($name, "cluster")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
    
    public function deletegalaxyAction($name) {
        
        $del = $this->curvl_del($name, "galaxy")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
    
    public function deleteplanetAction($name) {

        $del = $this->curvl_del($name, "planet")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
    
    public function deletestarAction($name) {
        
        $del = $this->curvl_del($name, "star")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
    
    public function deletesolarsystemAction($name) {
        
        $del = $this->curvl_del($name, "solarsystem")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
    
    public function deleteblackholeAction($name) {

        $del = $this->curvl_del($name, "blackhole")->status;
        
        $this->dispatcher->forward(
            array(
                "controller" => "kostyapi",
                "action"     => "index"
            )
        );
    }
}

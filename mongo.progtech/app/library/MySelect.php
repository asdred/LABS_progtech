<?php

use Phalcon\Forms\Element;

class MySelect extends Element
{
    protected $_name;
    protected $_optionsValues;
    protected $_selectedNumber;
    
    public function __construct($name, $options = null, $selected_number = null, $attributes = null)
	{
        $this->_name = $name;
		$this->_optionsValues = $options;
        $this->_selectedNumber = $selected_number;
		parent::__construct($name, $attributes);
	}
    
    public function render($attributes = null)
    {   
        $html = '<select id="'.$this->_name.'" name="'.$this->_name.'" class="form-control">';
        
        $objects = $this->_optionsValues;
        $selected_number = $this->_selectedNumber;
        
        foreach($objects as $obj) {
            
            if ($obj->model) {
                if ($obj->id == $selected_number) {
                    $html .= '<option value="'.$obj->id.'" selected>' . $obj->model . "</option>";
                } else {
                    $html .= '<option value="'.$obj->id.'">' . $obj->model . "</option>";
                }
            } elseif ($obj->name) {
                if ($obj->id == $selected_number) {
                    $html .= '<option value="'.$obj->id.'" selected>' . $obj->name . "</option>";
                } else {
                    $html .= '<option value="'.$obj->id.'">' . $obj->name . "</option>";
                }
            } elseif ($obj->id) {
                if ($obj->id == $selected_number) {
                    $html .= '<option value="'.$obj->id.'" selected>' . $obj->id . "</option>";
                } else {
                    $html .= '<option value="'.$obj->id.'">' . $obj->id . "</option>";
                }
            }
        }
        
        $html .= "</select>";
        
        return $html;
    }
}
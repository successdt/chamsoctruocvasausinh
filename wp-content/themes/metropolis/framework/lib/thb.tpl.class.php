<?php

/**
 * THB Templating class
 *
 * @package THB
 * @author The Happy Bit
 **/
class THBTpl
{
	
	/**
	 * Template directory
	 *
	 * @var string
	 */
	static $tpl_dir = "tpl/";
	
	/**
	 * The name of the template file
	 *
	 * @var string
	 **/
	var $name;
	
	/**
	 * The data array
	 *
	 * @var array
	 **/
	var $data = array();
	
	/**
	 * Constructor
	 */
	function THBTpl()
	{
		$this->data = array();
	}
	
	/**
	 * Configures the instance of THBTpl
	 *
	 * @return void
	 **/
	static function configure($setting, $value)
	{
		if( property_exists(__CLASS__, $setting) )
			self::$$setting = $value;
	}
	
	/**
	 * Assigns a key/value pair to the current template
	 *
	 * @return void
	 **/
	public function assign($key, $value="")
	{
		if(!empty($key)) {
			$this->data[$key] = $value;
		}
	}
	
	/**
	 * Draws a template or returns it
	 *
	 * @return mixed
	 **/
	public function draw($name, $return=false)
	{
		$thb_template_name = $name;		
		extract($this->data);		
		$thb_template_content = "";
		ob_start();
		include self::$tpl_dir . "{$thb_template_name}.php";
		$thb_template_content = ob_get_contents();
		ob_end_clean();
		
		if($return)
			return $thb_template_content;
		else
			echo $thb_template_content;
	}
	
}
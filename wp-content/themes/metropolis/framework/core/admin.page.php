<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/*
 * Generic administration page
 */
class adminpage {

	/**
	 * The page's name
	 *
	 * @var string
	 **/
	var $pageName;
	
	/**
	 * The page's title
	 *
	 * @var string
	 **/
	var $pageTitle;

	/**
	 * The page's message
	 *
	 * @var string
	 */
	var $message;

	/**
	 * Global options modifiable by the theme options
	 *
	 * @var array
	 **/
	public static $global_overridden_keys = array("posts_per_page", "page_on_front");
	
	/*
	 * Opens a container
	 */
	protected function open_container($class="") {
		return "<div class=\"$class\">";
	}
	
	/*
	 * Closes a container
	 */
	protected function close_container() {
		return "</div>";
	}
	
	/*
	 * Creates the form navigation
	 */
	protected function form_nav($sections) {
		$nav_tpl = new THBTpl;
		$nav_tpl->assign("sections", $sections);
		// $nav_tpl->assign("pageimage", PAGESURL . "/i/{$_GET['page']}-menu-page-");
		$nav_tpl->assign("pageimage", PAGESURL . "/i/menu-page-");
		$nav_tpl->assign("pageimage_ext", ".png");
		return $nav_tpl->draw('form_nav', true);
	}
	
	/*
	 * Opens a form
	 */
	protected function form_open($index) {
		$form_tpl = new THBTpl;
		$form_tpl->assign("index", $index);
		$form_tpl->assign("action", $_SERVER['PHP_SELF']);
		$form_tpl->assign("page", $_GET['page']);
		return $form_tpl->draw('form_open', true);	
	}

	/*
	 * Closes a form
	 */
	protected function form_close() {
		$form_tpl = new THBTpl;
		$form_tpl->assign("save", "Save");
		$form_tpl->assign("reset", "Reset");
		return $form_tpl->draw('form_close', true);
	}
	
	/*
	 * Renders the infobox
	 */
	protected function infobox($name = null, $section = null) {
		if($name && $section) {
			$ref = $section;
		}
		else {
			$name = $this->name;
			$ref = $this->field;
		}
		
		$infobox_tpl = new THBTpl;
		$infobox_tpl->assign("name", "Need help?");
		
		if(isset($ref['infobox']) && $ref['infobox'] != "") {
			$infobox_tpl->assign("desc", $ref['infobox']);
			return $infobox_tpl->draw("field_infobox", true);
		} else {
			return "";
		}
	}

	/**
	 * Gets the page title
	 */
	protected function getPageTitle() {
		global $theme;
		$pages = $theme['menu'];
		foreach($pages as $page) {
			if(thb_make_slug($page) == $_GET['page'])
				return $page;
		}
		return "";
	}
	
	/*
	 * Renders the page
	 */
	public function render() {
		if(!$this->isAdmin())
			return;

		$page = new THBTpl;
		$page->assign("themename", THEMENAME);
		$page->assign("themeversion", THEMEVERSION);
		$page->assign("frameworkname", FRAMEWORKNAME);
		$page->assign("frameworkversion", FRAMEWORKVERSION);
		$page->assign("pagetitle", $this->getPageTitle());
		$page->assign("pagetype", $this->pagetype);

		$page->assign("message", "");
		if(!empty($this->message))
			$page->assign("message", $this->message());

		$page->assign("content", $this->_render());
		$page->draw("admin_page");
	}
	
	/*
	 * Prepares the query result to be inserted as options of a SELECT tag.
	 */
	public function prepare_for_select($query) {
		$options = array();
		if($query->have_posts()) {
			while($query->have_posts()) {
				$query->the_post();
				$options[get_the_ID()] = get_the_title();
			}
		}
		return $options;
	}
	
	/*
	 * Renders a form field
	 */
	public function field($field, $context, $return = false) {
		extract($field);

		$field_tpl = new THBTpl;
		$field_tpl->assign("name", __($name));
		
		// Help?
		$field_tpl->assign("help", "");
		if(isset($desc) && $desc != "") {
			$field_help = new THBTpl;
			$field_help->assign("desc", $desc);
			$field_tpl->assign("help", $field_help->draw("field_help", true));
		}

		// Is this a switchable field?
		$is_switch = isset($onchange);
		
		// Rowclass
		$baseclass = "hb-row " . $context;
		if(isset($rowclass))
			$baseclass .= " " . $rowclass;
		if($is_switch)
			$baseclass .= " switch";
		$field_tpl->assign("rowclass", $baseclass);
		
		// Key
		$basekey = $key;
		$key = THEMEPREFIX . $key;
		$field_tpl->assign("basekey", $basekey);
		$field_tpl->assign("k", $key);

		// Custom parameters
		if( isset($parameters) && !empty($parameters) ) {
			foreach($parameters as $k => $v) {
				$field_tpl->assign("param_$k", $v);
			}
		}

		// Value
		switch($context) {
			case 'option':
				if( in_array(substr($key, strlen(THEMEPREFIX . "_")), adminpage::$global_overridden_keys) ) {
					$key = substr($key, strlen(THEMEPREFIX . "_"));
				}

				$value = get_option($key);
				$field_tpl->assign("v", thb_getvalue($value));
				break;
			case 'post':
				$value="";
				if(isset($_GET['post'])) {
					$post_id = $_GET['post'];
					$value = get_post_meta($post_id, $key, true);
				}
				$field_tpl->assign("v", thb_getvalue($value));
				break;
			case 'duplicable':
				// Value is passed from outside through $field				
				$keys = array_keys($value);
				foreach($keys as $k) {
					$value[$k] = thb_getvalue($value[$k]);
				}

				$field_tpl->assign("v", $value);
				break;
		}

		$field_content = "";

		switch($type) {
			case 'entry' : 
				$entries = thb_get_posts($post_type, array('orderby' => 'id', 'order' => 'desc', 'posts_per_page' => 999));
				$field['options'] = adminpage::prepare_for_select($entries);
				$field['type'] = "select";
				$field_content = adminpage::field($field, $context, true);
				break;
			case 'page' : 
				$pages = thb_get_posts('page', array('orderby' => 'title', 'order' => 'asc', 'posts_per_page' => 999));
				$field['options'] = $this->prepare_for_select($pages);
				$field['options']['0'] = "&mdash;";
				ksort($field['options']);
				
				$field['type'] = "select";
				$field_content = $this->field($field, $context, true);
				break;
			case 'heading':
				$field_content = $field_tpl->draw("field_heading", true);
				break;
			case 'textarea':
				if(!isset($rows)) $rows=3;
				$field_tpl->assign("rows", $rows);
				$field_tpl->assign("textareaclass", "");
				$field_content = $field_tpl->draw("field_textarea", true);
				break;
			case 'textareacode':
				if(!isset($rows)) $rows=3;
				$field_tpl->assign("rows", $rows);
				$field_tpl->assign("textareaclass", "code");
				$field_content = $field_tpl->draw("field_textarea", true);
				break;
			case 'checkbox':
				$checked="";
				if($value == "1") $checked = " checked";
				$field_tpl->assign("checked", $checked);
				$field_content = $field_tpl->draw("field_checkbox", true);
				break;
			case 'radio':
				$field_tpl->assign("options", $options);
   				if(!isset($desc) OR $desc == "")
   					$field_tpl->assign("divclass", "no-desc");
   				$field_content = $field_tpl->draw("field_radio", true);
   				break;
   			case 'select':
   				$field_tpl->assign("options", $options);

   				if($is_switch) {
   					$field_tpl->assign("dataswitch", json_encode($onchange));
   				}

   				$field_content = $field_tpl->draw("field_select", true);
   				break;
   			case 'color':
   				$field_tpl->assign("size", 8);
   				$field_content = $field_tpl->draw("field_color", true);
   				break;
   			case 'background':
   				$field_tpl->assign("color", "Color");
   				$field_tpl->assign("text", "Text");
   				$field_tpl->assign("headline", "Headline");
   				$field_tpl->assign("link", "Link");
   				$field_tpl->assign("hover", "Hover");
				$field_tpl->assign("pattern", "Pattern");
				$field_tpl->assign("preview", "Preview");
   				$field_content = $field_tpl->draw("field_background", true);
   				break;
   			case 'font':
   				$field_tpl->assign("family", "Family");
   				$field_tpl->assign("size", "Size");
   				$field_tpl->assign("weight", "Weight");
   				$field_tpl->assign("style", "Style");
   				$field_tpl->assign("options", $options);
   				$field_content = $field_tpl->draw("field_font", true);
   				break;
   			case 'googlefont':
   				$field_tpl->assign("family", "Family");
   				$field_tpl->assign("size", "Size");
   				$field_tpl->assign("lineheight", "Lineheight");
   				$field_tpl->assign("weight", "Weight");
   				$field_tpl->assign("style", "Style");
   				$field_tpl->assign("options", $options);
   				$field_content = $field_tpl->draw("field_googlefont", true);
   				break;
			case 'upload':
				$field_tpl->assign("upload", "Upload");
				$field_tpl->assign("reset", "Reset");
				$field_tpl->assign("save", "Save");
				$field_content = $field_tpl->draw("field_upload", true);
				break;
			case 'slide':
				$field_tpl->assign("caption", "Caption");
				$field_tpl->assign("title", "Title");
				$field_tpl->assign("url", "URL");
				$field_tpl->assign("upload", "Upload");
				$field_tpl->assign("reset", "Reset");
				$field_tpl->assign("save", "Save");
				$field_tpl->assign("remove", "Remove");
				$field_tpl->assign("type", "Type");
				$field_content = $field_tpl->draw("field_slide", true);
				break;
			case SIDEBAR:
				$field_tpl->assign("title", "Sidebar name");
				$field_tpl->assign("remove", "Remove");
				$field_content = $field_tpl->draw("field_sidebar", true);
				break;
			case STRIPE:
				$field_tpl->assign("title", "Horz stripe");
				$field_tpl->assign("remove", "Remove");
				$field_content = $field_tpl->draw("field_stripe", true);
				break;
			case CUSTOMFONT:
				$field_tpl->assign("title", "Custom font");
				$field_tpl->assign("remove", "Remove");
				$field_content = $field_tpl->draw("field_customfont", true);
				break;
			case 'box':
				$field_tpl->assign("basekey", $basekey);
				$field_tpl->assign("text", "Text");
				$field_tpl->assign("buttontext", "Button text");
				$field_tpl->assign("target", "Button page");
				$field_tpl->assign("url", "Button URL");
				$field_content = $field_tpl->draw("field_box", true);
				break;
			case 'number':
				$field_content = $field_tpl->draw("field_number", true);
				break;
			case 'date':
				$field_content = $field_tpl->draw("field_date", true);
				break;
			case 'field_container_open':
				$field_content = $field_tpl->draw("field_container_open", true);
				break;
			case 'field_container_close':
				$field_content = $field_tpl->draw("field_container_close", true);
				break;
			case 'text':
			default:
				if( isset($size) )
					$field_tpl->assign("size", $size);
				$field_content = $field_tpl->draw("field_text", true);
				break;
		}

		if($return)
			return $field_content;
		else
			echo $field_content;
	}

	/*
	 * Saves the data
	 */
	public function save() {
		$message = $this->_save();
		return $message;
	}

	/**
	 * Sets a message for the current page
	 *
	 * @return void
	 * @param string
	 **/
	public function setMessage($message)
	{
		if(!empty($message))
			$this->message = $message;
		else
			$this->message = "";
	}
	
	/*
	 * Displays a message
	 */
	public function message($return=true) {
		if(empty($this->message))
			return "";

		$message_tpl = new THBTpl;
		$message_tpl->assign("type", "success");
		$message_tpl->assign("message", $this->message);

		if($return)
			return $message_tpl->draw('message', true);
		else
			$message_tpl->draw('message'); 
	}

	/**
	 * Clears and sanitizes the POST data
	 */
	 public function clearPostData($data) {
	 	$forbidden_keys = array("save", "duplicate", "reset", "thb_admin_page_saved");
	 	foreach($forbidden_keys as $key)
	 		unset($data[$key]);

	 	foreach(adminpage::$global_overridden_keys as $key) {
	 		if( isset($data[THEMEPREFIX . "_" . $key]) ) {
	 			$newkey = $key;
	 			$data[$newkey] = $data[THEMEPREFIX . "_" . $key];
	 			unset($data[THEMEPREFIX . "_" . $key]);

	 			// Multiple save
	 			if( $key == "page_on_front" ) {
	 				if( $data[$newkey] != 0 )
	 					$data["show_on_front"] = "page";
	 				else
	 					$data["show_on_front"] = "posts";
	 			}
	 				
	 		}
	 	}

	 	return $data;
	 }

	 /**
	  * Checks if we're in the administration panel
	  */
	public function isAdmin() {
		$file = basename($_SERVER['PHP_SELF']);
		return $file == "admin.php";
	}
}

/*
 * An administration page that handles just good ol' WordPress options
 */
class optionpage extends adminpage {
	
	private $sections;
	public $pagetype = "options";
	
	public function optionpage($sections) {
		$this->sections = $sections;
	}
	
	/*
	 * Renders the controls
	 */
	public function controls() {
		$controls_tpl = new THBTpl;
		$controls_tpl->assign("save", __("Save", THEMENAME));
		return $controls_tpl->draw("form_controls", true);
	}

	/**
	 * Get field from its key
	 */
	public function getField($sectionName, $key) {
		$fields = $this->sections[$sectionName];
		foreach($fields['fields'] as $field)
			if($field["key"] == $key)
				return $field;

		return false;
	}

	/**
	 * Parse section field
	 */
	public function parseField($name, $field, &$styles, $display='block') {
		if( isset($field['onchange']) ) {

			$key = THEMEPREFIX . $field['key'];
			if( in_array(substr($key, strlen(THEMEPREFIX . "_")), adminpage::$global_overridden_keys) ) {
				$key = substr($key, strlen(THEMEPREFIX . "_"));
			}

			$value = get_option($key);
			$onChangeFields = $field['onchange'];

			foreach( $onChangeFields as $option => $targetFields ) {
				$targetFields = explode(",", $targetFields);

				for($i=0; $i<count($targetFields); $i++) {
					$basekey = $targetFields[$i];
					$targetFields[$i] = "#" . THEMEPREFIX . $basekey;

					if( !isset($styles[$targetFields[$i]]) ) {
						if( $display == 'block' )
							$display = $value == $option ? 'block' : 'none';

						$styles[$targetFields[$i]] = $display;
					}

					$tf = $this->getField($name, $basekey);
					$this->parseField($name, $tf, $styles, $display);
				}
			}

		}
	}
	
	/*
	 * Renders the sections and their fields
	 */
	public function _render() {

		$styles = array();
		foreach($this->sections as $name => $fields) {
			foreach($fields['fields'] as $field) {
				$this->parseField($name, $field, $styles);
			}
		}

		echo "<style type='text/css'>";
			foreach($styles as $selector => $display)
				echo $selector . "{ display: " . $display . "; }\n";
		echo "</style>";

		$content = "";
		$content .= $this->form_nav($this->sections);
		$i=1;
		foreach($this->sections as $name => $fields) {
			$content .= $this->form_open($i);
			$content .= $this->infobox($name, $fields);
			foreach($fields['fields'] as $field) {
				$content .= $this->field($field, "option", true);
			}
			$content .= $this->controls();
			$content .= $this->form_close($fields['fields']);
			$i++;
		}
		return $content;
	}

	/**
	 * Checks if an option is already present in the database
	 */
	public function isOptionPresent($key)
	{
		$optionNotPresent = "THB_OPTION_NOT_PRESENT";
		$option = get_option($key, $optionNotPresent);

		return $option != $optionNotPresent;
	}
	
	/*
	 * Saves the page
	 */
	public function _save() {
		if(empty($_POST)) 
			return "";

		$action = isset($_POST['save']) ? "save" : "duplicate";
		$data = $this->clearPostData($_POST);

		$message="";

		switch($action) {
			case 'save':
				foreach($data as $option => $value) {
					update_option($option, $value);
				}
				$message = __("All saved!", THEMENAME);

				break;
		}

		return $message;
	}
	
}

class duplicablepage extends adminpage {
	
	public $field;
	public $field_type;
	public $table_name;
	public $pagetype = "duplicable";
	
	public function duplicablepage($fields) {
		global $wpdb;
		foreach($fields as $name => $field) {
			$this->name = $name;
			$this->field = $field;
			$this->field_type = $this->field['field']['group'];
			break;
		}
		
		$this->table_name = DUPLICABLE_TABLE;
	}
	
	/*
	 * Retrieves the items from the database
	 */
	private function get_items() {
		$key = $this->field['field']['key'];
		$type = $this->field_type;
		
		$items = thb_get_duplicable($type);
		return $items;
	}
	
	/*
	 * Renders the controls
	 */
	public function controls($position) {
		$controls_tpl = new THBTpl;
		$controls_tpl->assign("save", "Save");
		$controls_tpl->assign("add", "Add");
		$controls_tpl->assign("template", $this->field['field']['key']);
		$controls_tpl->assign("group", $this->field['field']['group']);
		$controls_tpl->assign("collapse", "Collapse all");
		$controls_tpl->assign("expand", "Expand all");
		$controls_tpl->assign("position", $position);
		return $controls_tpl->draw("form_controls_duplicable", true);
	}
	
	/*
	 * Renders the duplicable template
	 */
	private function template() {
		$template = new THBTpl;
		$template->assign("name", $this->field['field']['key']);
		
		$this->field['field']['value'] = array(
			"src" => "",
			"ord" => "",
			"url" => "",
			"subtype" => "",
			"title" => "",
			"caption" => "",
			"name" => ""
		);
					
		$template->assign("content", $this->field($this->field['field'], "duplicable", true));
		
		return $template->draw("template", true);
	}
	
	/*
	 * Renders the database-saved fields and the duplicable template
	 */
	public function _render() {
		$content = "";
		$content .= $this->form_open(0);
		// $content .= $this->controls("top");
		
		$content .= $this->open_container("duplicable-section");
		$items = $this->get_items();

		if( count($items) == 0 ) {
			$content .= $this->infobox();
		}

		foreach($items as $item) {
			$this->field['field']['value'] = $item;
			$content .= $this->field($this->field['field'], "duplicable", true);
		}
		$content .= $this->template();
		$content .= $this->close_container();
		
		$content .= $this->controls("bottom");
		$content .= $this->form_close();
		
		return $content;
	}
	
	/*
	 * Saves the page
	 */
	public function _save() {
		$message = "";

		if(!empty($_POST)) {
			global $wpdb;

			$data = $this->clearPostData($_POST);

			$table_name = $this->table_name;
			$type = $this->field_type;

			$wpdb->query("DELETE FROM {$table_name} WHERE type = '{$type}'");

			$fields = array_keys($data);

			if(isset($fields[0]) && isset($data[$fields[0]])) {
				$num_items = count($data[$fields[0]]);
				$items_keys = array_keys($data[$fields[0]]);

				foreach($items_keys as $i) {
					$item = array();
					foreach($fields as $field) {
						$tokens = explode("_", $field);
						$key = $tokens[count($tokens)-1];
						$item[$key] = $_POST[$field][$i];
					}
					$item['type'] = $type;

					$rows_affected = $wpdb->insert(
						$table_name,
						$item
					);
				}

			}

			$message = __("All saved!", THEMENAME);
		}

		return $message;
	}
	
}

class helppage extends adminpage {

	var $helpText = "";
	var $pagetype = "help";

	public function setHelpText($ht)
	{
		$this->helpText = $ht;
	}

	/*
	 * Renders the page
	 */
	public function render() {
		if(!$this->isAdmin())
			return;

		$page = new THBTpl;
		$page->assign("themename", THEMENAME);
		$page->assign("themeversion", THEMEVERSION);
		$page->assign("frameworkname", FRAMEWORKNAME);
		$page->assign("frameworkversion", FRAMEWORKVERSION);
		$page->assign("pagetitle", $this->getPageTitle());

		$page->assign("pagetype", $this->pagetype);
		$page->assign("message", "");

		$page->assign("content", $this->_render());

		$page->draw("admin_helppage");
	}
	
	public function _render()
	{
		return $this->helpText;
	}

}

/**
 * Create a list of options from a multi-dimensioned array
 */
function getOptionsFromArray($options, $value) {
	$opts = "";
	foreach($options as $k => $v) {
		$selected = $value == $k ? "selected" : "";
		$opts .= "<option value='$k' $selected>$v</option>";
	}
	return $opts;
}

/**
 * Create a structured list of options from a multi-dimensioned array
 */
function getStructuredOptionsFromArray($input, $value) {
	$opts = "";

	foreach( $input as $optgroup => $options ) {
		$opts .= "<optgroup label='$optgroup'>";
			foreach($options as $k => $v) {
				$selected = $value == $k ? "selected" : "";
				$opts .= "<option value='$k' $selected>$v</option>";
			}
		$opts .= "</optgroup>";
	}

	return $opts;
}
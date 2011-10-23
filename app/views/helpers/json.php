<?php

	/*
	 * Class for outputting JSON stuff for AJAX
	 */

class JsonView extends View {

	function render($action = null, $layout = null, $file = null){
		if(!isset($this->viewVars['json'])){
			return parent::render($action, $layout, $file);
		}

		$vars = $this->viewVars['json'];

		if(is_array($vars)){
			$jsonVars = array();
			foreach($vars as $var){
				if(isset($this->viewVars[$var])){
					$jsonVars[$var] = $this->viewVars[$var];
				}else{
					$jsonVars[$var] = null;
				}
			}
			header('Content-type: application/json');
			Configure::write('debug',0);
			return json_encode($jsonVars);
		}
		return 'null';
	}

}

?>

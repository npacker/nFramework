<?php

class View {

	protected $variables = array();

	public function set($key, $value) {
		$this->variables[$key] = $value;
	}
	
	public function render() {
	  print $this->renderPage($this->processTemplate());
	}
	
	protected function renderPage($page) {
	  $page_title = $this->variables['title'];
	
	  ob_start();
	
	  include ROOT . DS . 'templates' . DS . 'html.tpl.php';
	
	  return ob_get_clean();
	}

}
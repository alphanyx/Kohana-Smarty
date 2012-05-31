## Kohana Smarty View Modul


With the Smarty Modul is it possible to render the views with the Smarty Engine.

**Example Use:**

	class Controller_Example extends Controller {
		$view = new Smarty();
		$view->SmartyVariable = 'Hallo Welt!';
	
		$template = 'example/index';
	
		$this->response->body($view->render($template));
	}
	
This Example Class would load the view file in path

	application/views/example/index.html
	
Or in each other module directory with a view directory.

**Notice:**

This Module requires the Autoload Modul for Kohana:

	https://github.com/mikelfroese/Kohana-Autoload



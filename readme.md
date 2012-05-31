## Kohana Smarty View Modul


With the Smarty Modul is it possible to render the views with the Smarty Engine.

**Example Use:**

	
	use \Modules\Smarty;

	class Controller_Example extends Controller {
		$view = new Smarty();
		$view->var = 'Hello World!';
	
		$template = 'example/index';
	
		$this->response->body($view->render($template));
	}
	
This Example Class would load the view file in path

	application/views/example/index.html
	
Now is it possible to use the Variable $var in the template file.

	{$var} // will print "Hello World!"
	
Or in each other module directory with a view directory.

**Notice:**

This Module requires the Autoload Modul for Kohana:

	https://github.com/mikelfroese/Kohana-Autoload



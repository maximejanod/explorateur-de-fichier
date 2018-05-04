
<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/php/functions.php';

   define('ROOT_FOLDER', 'root');

$twig = new Twig_Environment(new Twig_Loader_Filesystem('./templates'), [
  'cache' => false,
  'debug' => true
]);

if(empty($_GET)) {
  echo $twig->render('simple.html', getHome());
} else {

  if(isset($_GET['view'])) {
    $view = $_GET['view'];
    switch($view) {
      case 'simple':
        $template = 'simple';
        break;
      case 'details':
        $template = 'details';
        break;
      default:
        $template = 'error';
        break;
    }

    echo $twig->render($template.'.html', getData($view));
  }
}

?>

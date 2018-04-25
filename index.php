
<?php

define('ROOT_FOLDER', 'root');

require_once __DIR__.'/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('./templates');
$twig   = new Twig_Environment($loader, array(

    'cache' => './cache'
  , 'debug' => true

));

function checkGet(array $get): array {

  if(empty($_GET)) {

    return array(

        'breadcrumb'    => getBreadcrumb(ROOT_FOLDER)
      , 'scaffolding'   => listFolder(ROOT_FOLDER, 'false')

    );

  } else {

    if(isset($_GET['path']) && isset($_GET['sound'])) {

      $path = $_GET['path'];

      if(substr($path, 0, 4) === 'root' && file_exists($path)) {

        return array(

            'breadcrumb'    => getBreadcrumb($path)
          , 'scaffolding'   => listFolder($path, $_GET['sound'])

        );

      } else {

        return array(

            'error'       => 'Désolé, ce dossier n\'est pas accessible.'
          , 'breadcrumb'  => getBreadcrumb(ROOT_FOLDER)

        );

      }

    } else {

      return array(

          'error'       => 'Désolé, une erreur s\'est produite.'
        , 'breadcrumb'  => getBreadcrumb(ROOT_FOLDER)

      );

    }

  }

}

function getBreadcrumb(string $path): array {

  $exploded   = explode('/', $path);
  $breadcrumb = [];
  $step       = '';

  foreach($exploded as $explode) {

    $step .= $explode.'/';

    array_push($breadcrumb, ['name' => $explode, 'path' => substr($step, 0, -1)]);

  }

  return $breadcrumb;

}

function listFolder(string $folder, string $sound = 'false'): array {

  $scaffolding = array_diff(scandir($folder), array('.', '..'));

  $folders = $files = [];

  foreach($scaffolding as $element) {

    $path = $folder.DIRECTORY_SEPARATOR.$element;

    if(is_dir($path)) {

      array_push($folders, ['name' => $element, 'path' => $path]);

    } else {

      array_push($files, [

          'name' => $element
        , 'path' => $path
        , 'icon' => getIcon($element)
        , 'size' => filesize($folder.'/'.$element)
        , 'date' => date('d F Y - H:i:s', filemtime($folder.'/'.$element))

      ]);

    }

  }

  return array(

      'folders'   => $folders
    , 'files'     => $files
    , 'sound'     => $sound === 'true' ? getRandomSound() : false
    , 'name'      => 'Bobby Flex'

  );

}

function getIcon(string $file): string {

  $exploded   = explode('.', $file);
  $extension  = end($exploded);

  if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg' || $extension === 'gif') {

    $icon = 'image';

  } else if($extension === 'mp3') {

    $icon = 'music';

  } else if($extension === 'mp4') {

    $icon = 'video';

  } else {

    $icon = 'file';

  }

  return $icon;

}

function getRandomSound() {

  $sounds = array_values(array_diff(scandir('assets/sounds'), array('.', '..')));

  return $sounds[array_rand($sounds)];

}

echo $twig->render('explorer.html', checkGet($_GET));

?>

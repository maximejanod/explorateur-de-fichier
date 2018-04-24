
<?php

$rootFolder = 'root';

function checkGet(array $get): string {

  if(isset($_GET['path']) && isset($_GET['sound'])) {

    $path = $_GET['path'];

    if(substr($path, 0, 4) === 'root' && file_exists($path)) {

      return listFolder($path, $_GET['sound']);

    } else {

      return '<p class="error">Désolé, une erreur s\'est produite.</p>';

    }

  } else {

    return '<p class="error">Désolé, une erreur s\'est produite.</p>';

  }

}

function listFolder(string $folder, string $sound = 'false'): string {

  $scaffolding = array_diff(scandir($folder), array('.', '..'));

  if(count($scaffolding) > 0) {

    $folders = $files = [];

    $data = '<form method="get">
              <ul>';

    foreach($scaffolding as $element) {

      $path = $folder.DIRECTORY_SEPARATOR.$element;

      if(is_dir($path)) {

        array_push($folders, [$element, $path]);

      } else {

        array_push($files, [$path, $element, filesize($folder.'/'.$element), date('d F Y - H:i:s', filemtime($folder.'/'.$element))]);

      }


    }

    foreach($folders as $folder) {

      $data .= '<li class="folder">
                  <a href="explorer.php?path='.$folder[1].'&sound=true">
                    <img class="i-folder" src="assets/icons/folder.png" alt="folder icon">'.$folder[0].
                  '</a>
                </li>';

    }

    foreach($files as $file) {

      $path = $file[0];
      $name = $file[1];
      $size = $file[2];
      $date = $file[3];

      $formatted = $size != 0 ? 'octets' : 'octet';

      $data .= '<li class="file">
                  <img class="i-file" src="assets/icons/'.getIcon($name).'.png" alt="file icon">
                  <a href="'.$path.'" download>'.$name.'</a>
                  <span class="details">'.$size.' '.$formatted.' / '.$date.
                  '</span>
                </li>';

    }

    $data .= '</ul></form>';

    if($sound == 'true') {

      $data .= '<audio src="assets/sounds/'.getRandomSound().'" autoplay></audio>';
      // $data .= '<audio src="assets/sounds/explorer.mp3" autoplay></audio>';

    }

    return $data;

  } else {

    return '<p class="error">Désolé, une erreur s\'est produite.</p>';

  }

}

function getBreadcrumb(string $path): string {

  $exploded       = explode('/', $path);
  $breadcrumb     = '';
  $step           = '';

  foreach($exploded as $explode) {

    $step .= $explode.'/';

    $breadcrumb .= '<li class="breadcrumb-item"><a href="explorer.php?path='.substr($step, 0, -1).'&sound=false">'.$explode.'</a></li>';

  }

  return '

     <form method="get">
       <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
           '.$breadcrumb.'
         </ol>
       </nav>
     </form>

   ';

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

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href=".png"/>
    <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/explorer.css">
    <title></title>
  </head>
  <body>
    <div class="container">

      <h1>Explorator</h1>

      <?php echo empty($_GET) ? getBreadcrumb($rootFolder) : getBreadcrumb($_GET['path']); ?>

      <div class="content">
        <?php echo empty($_GET) ? listFolder($rootFolder, 'false') : checkGet($_GET); ?>
      </div>

    </div>
    <script src="assets/js/explorer.js"></script>
  </body>
</html>


<?php

$rootFolder = 'root';

function listFolder(string $from): string {

  $scaffolding = array_diff(scandir($from), array('.', '..'));

  $folders  = [];
  $files    = [];

  $data = '<form method="get">
            <ul>';

  foreach($scaffolding as $element) {

    $path = $from.DIRECTORY_SEPARATOR.$element;

    if(is_dir($path)) {

      array_push($folders, [$element, $path]);

    } else {

      array_push($files, $element);

    }


  }

  foreach($folders as $folder)
    $data .= '<li class="folder">
                <a href="explorer.php?path='.$folder[1].'">
                  <img class="i-folder" src="assets/icons/folder.png" alt="folder icon">'.$folder[0].
                '</a>
              </li>';

  foreach($files as $file)
    $data .= '<li class="file">
                <img class="i-file" src="assets/icons/file.png" alt="file icon">'.$file.
             '</li>';

  return $data .=     '</ul>
                   </form>';

}

function getBreadcrumb(string $path): string {

 return '

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">'.$path.'</li>
      </ol>
    </nav>

  ';

}

?><DOCTYPE html>
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
        <?php echo empty($_GET) ? listFolder($rootFolder) : listFolder($_GET['path']); ?>
      </div>

    </div>
    <script src="assets/js/explorer.js"></script>
  </body>
</html>

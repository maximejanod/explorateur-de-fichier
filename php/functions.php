
<?php

   function getHome(): array {
     return [
       'breadcrumb'    => getBreadcrumb(ROOT_FOLDER),
       'scaffolding'   => listFolder(ROOT_FOLDER, false),
       'uri'           => '?path=root&sound=false&view=',
       'view'          => 'simple'
     ];
   }

function getData(string $view): array {
  if(isset($_GET['path']) && isset($_GET['sound'])) {
    $path = $_GET['path'];

    if(substr($path, 0, 4) === 'root' && !strpos($path, '..') && file_exists($path)) {
      return [
        'breadcrumb'    => getBreadcrumb($path),
        'scaffolding'   => listFolder($path, $_GET['sound']),
        'uri'           => '?path='.$path.'&sound=false&view=',
        'view'          => $view,
      ];
    } else {
      $error = 'Désolé, ce dossier n\'est pas accessible.';
    }
  } else {
    $error = 'Désolé, une erreur s\'est produite.';
  }
  return [
    'error'       => $error,
    'breadcrumb'  => getBreadcrumb(ROOT_FOLDER),
    'view'        => $view,
  ];
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

function listFolder(string $folder, string $sound): array {
  $scaffolding = array_diff(scandir($folder), array('.', '..'));
  $folders = $files = [];

  foreach($scaffolding as $element) {
    $path = $folder.DIRECTORY_SEPARATOR.$element;

    if(is_dir($path)) {
      array_push($folders, [
        'name'    => $element,
        'path'    => $path
      ]);
    } else {
      array_push($files, [
        'icon'    => getIcon($element),
        'name'    => $element,
        'path'    => $path,
        'type'    => mime_content_type($path),
        'size'    => filesize($path),
        'owner'   => posix_getpwuid(fileowner($path))['name'],
        'chmod'   => decoct(fileperms($path) & 0777),
        'date'    => date('d F Y - H:i:s', filemtime($path))
      ]);
    }
  }
  return [
    'folders'   => $folders,
    'files'     => $files,
    'sound'     => $sound === 'true' ? 'click.mp3' : false
  ];
}

function getIcon(string $file): string {
  $exploded   = explode('.', $file);
  $extension  = end($exploded);
  if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg' || $extension === 'gif') {
    $icon = 'image';
  } else if($extension === 'mp3' || $extension === 'wav') {
    $icon = 'music';
  } else if($extension === 'mp4') {
    $icon = 'video';
  } else {
    $icon = 'file';
  }
  return $icon;
}

?>

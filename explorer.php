
<?php

// root folder
$folder = 'root/';

// contain folders & files in $folder less . current folder & .. parent folder
$scaffolding = array_diff(scandir($folder), array('.', '..'));

// var_dump($scaffolding); die();

// declare empty arrays
$folders  = [];
$files    = [];

// open list
$data = '<ul>';

// loop to check if element is folder or file and push in good array
foreach ($scaffolding as $element)
  is_dir($folder.'/'.$element) ? array_push($folders, $element) : array_push($files, $element);

// loop on folders
foreach($folders as $folder)
  $data .= '<li class="folder"><img class="i-folder" src="assets/icons/folder.png" alt="folder icon">'.ucfirst($folder).'</li>';

// loop on files
foreach($files as $file)
  $data .= '<li class="file"><img class="i-file" src="assets/icons/file.png" alt="file icon">'.ucfirst($file).'</li>';

// close list
$data .= '</ul>';

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

      <div class="content">
        <?= $data; ?>
      </div>

    </div>
    <script src="assets/js/explorer.js"></script>
  </body>
</html>

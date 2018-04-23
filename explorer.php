
<?php

// phpinfo()

$folder = 'root/';

// contain folders & files in $folder less . current folder & .. parent folder
$scaffolding = array_diff(scandir($folder), array('.', '..'));

// var_dump($scaffolding);

foreach ($scaffolding as $element) {

  $step = $folder.'/'.$element;

  if(is_dir($step))
    echo '<p>Dossier : '.$element.'</p>';
  else
    echo '<p>Fichier : '.$element.'</p>';

}


?>

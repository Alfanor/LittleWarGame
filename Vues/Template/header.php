<!DOCTYPE html>
<html>
   <head>
      <title>LittleWarGame</title>

      <link rel="icon" href="/Vues/Images/favico.ico" />

      <meta charset="UTF-8">

      <?php
      if(isset($_HEADER))
      {
         foreach($_HEADER as $fichier)
            echo $fichier;
      }

      foreach($_CSS as $fichier)
         echo '<link href="Vues/Css/' . $fichier . '" rel="stylesheet" type="text/css" />';

      foreach($_JS as $fichier)
         echo '<script src="Vues/Javascript/' . $fichier . '"></script>';
      ?>
   </head>

   <body>
      <div id="conteneur">
         <div id="header">LittleWarGame</div>

         <div id="content">
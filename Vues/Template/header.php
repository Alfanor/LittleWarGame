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

         <div id="menu">
            <ul>
               <li><a href="?p=accueil"><?php echo $_LANGUAGE['FR']['MENU_ACCUEIL']; ?></a></li>
               <li><a href="?p=village"><?php echo $_LANGUAGE['FR']['MENU_VILLAGE']; ?></a></li>
               <li><a href="?p=temple"><?php echo $_LANGUAGE['FR']['MENU_TEMPLE']; ?></a></li>
            </ul>
         </div>

         <div id="content">
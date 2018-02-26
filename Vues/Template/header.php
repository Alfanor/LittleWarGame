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

         <?php
         if(isset($_SESSION['id']))
         {
         ?>

            <div id="menu">
               <ul class="menu">
                  <li><a href="?p=accueil"><?php echo $_LANGUAGE['FR']['MENU_ACCUEIL']; ?></a></li>
                  <li><?php echo $_LANGUAGE['FR']['MENU_VILLAGE']; ?><br/>
                     <ul class="submenu">
                        <?php
                        foreach($_SESSION['data']->getVillages() as $menu_village)
                           echo '<li><a href="?p=village&amp;id=' . $menu_village->getId() . '">' . $menu_village->getName() . '</a></li>'
                        ?>
                     </ul>
                  </li>
                  <li><a href="?p=temple"><?php echo $_LANGUAGE['FR']['MENU_TEMPLE']; ?></a></li>
               </ul>

               <span class="right"><?php echo $_LANGUAGE['FR']['MENU_TOUR'] . Round::getRoundNumber(); ?></span>
            </div>
         <?php
         }
         ?>
         
         <div id="content">
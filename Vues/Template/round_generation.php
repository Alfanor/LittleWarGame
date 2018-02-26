<?php
if(isset($_SESSION['id']))
{
    if($fraud)
        echo $_LANGUAGE['FR']['ROUND_FRAUD'];

    if(!$fraud && $erreur)
        echo $_LANGUAGE['FR']['ROUND_ERROR'];

    else
        echo $_LANGUAGE['FR']['ROUND_SUCCESS'];
}

else
    header('Location: index.php');
?>
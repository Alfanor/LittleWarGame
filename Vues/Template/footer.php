            </div>

            <div id="footer">
                &copy; LittleWarGame 2018 - 
                <?php
                if(isset($_SESSION['id']))
                    echo '<a href="?p=deconnexion">' . $_LANGUAGE['FR']['FOOTER_DECONNEXION'] . '</a>';
                ?>
                - <?php echo $_LANGUAGE['FR']['FOOTER_EXECUTION'] . ' : ' . ($end - $start); ?>
            </div>
        </div>
    </body>
</html>
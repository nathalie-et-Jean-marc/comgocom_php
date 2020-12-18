<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once 'classes/Identification.class.php';
     
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>index _ Home </title>
        <link rel="stylesheet" href="style/masterPage.css"/>
        <link rel="stylesheet" href="style/index.css"/>
        <link rel="icon" type="image/x-icon" href="images/hypathieIco.ico" />
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
<script type='text/javascript' src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <!--<script type="text/javascript" src="script/main.js"></script>-->
<script type="text/javascript">

    $(function() {
        var offset = $("#sidebar").offset();
        var topPadding = 15;
        $(window).scroll(function() {
            if ($(window).scrollTop() > offset.top) {
                $("#sidebar").stop().animate({
                    marginTop: $(window).scrollTop() - offset.top + topPadding
                });
            } else {
                $("#sidebar").stop().animate({
                    marginTop: 0
                });
            };
        });
    });

    $(function() {
        $('a[href=#top]').click(function(){
            $('html').animate({scrollTop:0}, 'slow');
            return false;
        });
    });
    /*jquery mobile */

    $(document).delegate('a.top', 'click', function () {
        $('html, body').stop().animate({ scrollTop : 0 }, 500);
        return false;
    });

</script>

<style>
#chantier {
    border:2px;
  text-align: center;
  color: DodgerBlue;
}
</style>

<?php
    $linking = false;
?>
    </head>
 
     <body>
        <div class="header";>
            <?php include("public/includes/headerIndex.php");  ?>
        </div>
        <div class="body">


            <div id="page-wrap">
            
                <div class="title-area">
                    <h1 id="chantier">Oups... Ce site est en chantier pour le moment !</h1>   
                    <h2 id="chantier">Les développeurs planchent... </h2>   
                    <p>

                    </p>
                </div>
                
            <div id="main">

            <figure>
                <img src="images/image_presentation.png" alt="Bloc-Notes" />

            </figure>



            </div>
                
                <div id="sidebar">		
                    <div id="sidebarTitre">Liens &nbsp &nbsp;</div>
                        <p>&nbsp &#8593 &nbsp<a href="#top">Haut de page</a></p>
                        <p class="titre">Plan du site : </p>
                        <ul>
                            
                            <li><a href="public/pages/contacts.php">Contacts</a></li>
                            <li>
                                <a <?php if($linking == true) { ?> href="wikis/doku.php" <?php } ?>>Wikis</a>
                                <!--<a href="wikis/doku.php">Wikis</a>!-->
                            </li>
                            <li>
                                <a <?php if($linking == true) { ?> href="public/pages/services.php" <?php } ?>>Services proposés</a>
                                <!--<a href="public/pages/services.php">Services proposés</a>!-->
                            </li>
                            <li>
                                <!--<a <?php if($linking == true) { ?> href="public/pages/charte.php" <?php } ?>>Charte de confidentialité</a>!-->
                                <a href="public/pages/charte.php">Charte de confidentialité</a>
                            </li>
                        </ul>
                        <!--<p class="titre">Autres liens : </p>
                        <ul>
                            <li><a href="public/pages/TestRequetes.php">TEST </a></li>
                        </ul>!-->
                    </div>
                </div>
            
            </div>
        </div>
        <div class="clear">
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>            

     </body>
</html>



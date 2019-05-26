<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!--======================================== CSS =======================================-->
    <?php echo Asset::css('foundation.css'); ?>
    <?php echo Asset::css('app.css'); ?>
    <?php echo Asset::css('gardenia.css'); ?>
    <?php echo Asset::css('font-awesome.min.css'); ?>
    <!--======================================== CSS END ===================================-->
  </head>

    <!--======================================== BODY ===================================-->
  <body>
  <div id="sidebar-wrapper">
    <?php require_once('sidebar.php'); ?>
  </div>

  <div id="main-wrapper">
    <!-- NAVBAR -->
    <?php require_once('nav.php'); ?>
    <div class="spacer"></div>

    <div class="grid-container">
		<h4><?php echo $title; ?></h4>

		<?php echo $content; ?>

    </div><!-- grid-container END -->
    <!-- FOOTER -->
    <?php require_once('footer.php'); ?>
<!--============================================ JS ==========================================================-->
	<?php echo Asset::js('vendor/jquery.js'); ?>
	<?php echo Asset::js('vendor/foundation.js'); ?>
	<?php echo Asset::js('app.js'); ?>
	<?php echo Asset::js('gardenia.js'); ?>

<!-- =========================================== JS END ==========================================================-->
  </div><!-- main-wrapper -->
  </body>
</html>

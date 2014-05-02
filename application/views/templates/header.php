<?php
/**
 * @category View Header
 * @description Main
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--
        <meta http-equiv="content-language" content="bg" />
        -->
        
        <meta name="viewport" content="width=device-width">
        <meta name="viewport" content="initial-scale=1">

        <title><?php echo $title; ?></title>
        <!-- stylesheets -->
        <!--My CSS files-->
        <link rel="stylesheet" href="<?php echo $baseDirectory; ?>application/views/includes/CSS/main.css" type="text/css" media="screen">
        <!--jQuery UI CSS files-->
        <?php /*
        <link rel="stylesheet" type="text/css" href="<?php echo $baseDirectory; ?>application/views/includes/CSS/libraries/jquery-ui-1.10.4.custom.min.css" media="screen">
        /**/ ?>
        
        <!-- jQuery - the core -->
        <script src="<?php echo $baseDirectory; ?>application/views/includes/JS/libraries/jquery-2.1.0.min.js" type="text/javascript"></script>
        <!--jQuery UI-->
        <?php /*
        <script type="text/javascript" src="<?php echo $baseDirectory; ?>application/views/includes/JS/libraries/jquery-ui-1.10.4.custom.min.js"></script>
        
        <!-- My JS files -->
        <script src="<?php echo $baseDirectory; ?>application/views/includes/JS/quiz.js" type="text/javascript"></script>
        <script src="<?php echo $baseDirectory; ?>application/views/includes/JS/cms.js" type="text/javascript"></script>
         * 
         /**/ ?>

    </head>
    <body>
        <input type="hidden" class="baseDirectory" value="<?php echo $baseDirectory; ?>">
        <div class="page-container">
            <div class="application-container">

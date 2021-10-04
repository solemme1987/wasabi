<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo wp_get_document_title(); ?></title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php wp_head(); ?>

    <!-- Google Analytics -->
    <?php global $url, $staging_sites; ?>
    <?php if (!strpos_array($url, $staging_sites)) : // exclude GA from staging site ?>
      <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-XXXXX-Y', 'auto');
      ga('send', 'pageview');
      </script>
    <?php endif; ?>
    <!-- End Google Analytics -->

  </head>
  <body id="<?php echo $pagename; ?>" <?php body_class(); ?>>
    <main>

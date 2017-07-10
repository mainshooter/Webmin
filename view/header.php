    <!DOCTYPE html>
    <html>
      <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $GLOBALS['config']['project-name']; ?></title>

        <meta name="application-name" content="&nbsp;"/>
        <meta name="msapplication-TileColor" content="#FFFFFF" />
        <meta name="msapplication-TileImage" content="icon/mstile-144x144.png" />
        <meta name="msapplication-square70x70logo" content="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/mstile-70x70.png" />
        <meta name="msapplication-square150x150logo" content="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/mstile-150x150.png" />
        <meta name="msapplication-wide310x150logo" content="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/mstile-310x150.png" />
        <meta name="msapplication-square310x310logo" content="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/mstile-310x310.png" />

        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-60x60.png" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/apple-touch-icon-152x152.png" />
        <link rel="icon" type="image/png" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/favicon-196x196.png" sizes="196x196" />
        <link rel="icon" type="image/png" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/png" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/favicon-16x16.png" sizes="16x16" />
        <link rel="icon" type="image/png" href="<?php echo $GLOBALS['config']['base_url']; ?>view/icon/favicon-128.png" sizes="128x128" />

        <link rel="stylesheet" href="<?php echo $GLOBALS['config']['base_url']; ?>/view/style/grid.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $GLOBALS['config']['base_url']; ?>/view/style/framework-style.css" type="text/css">

        <script src="<?php echo $GLOBALS['config']['base_url']; ?>/view/js/main.js"></script>
      </head>
    <body>

    <div class="header">
        <img src="<?php echo $GLOBALS['config']['base_url'] ?>/view/image/logo.png">
        <h1><a href="<?php echo $GLOBALS['config']['base_url'] ?>"><?php echo $GLOBALS['config']['project-name'] ?></a></h1>
        <div id="loader"></div>
    </div>
    <div class="col-3 col-m-12 menu">
      <ul>
        <li><a href="<?php echo $GLOBALS['config']['base_url'] ?>">Home</a></li>
        <li><a href="<?php echo $GLOBALS['config']['base_url'] ?>">The City</a></li>
        <li><a href="<?php echo $GLOBALS['config']['base_url'] ?>">The Island</a></li>
        <li><a href="<?php echo $GLOBALS['config']['base_url'] ?>">The Food</a></li>
      </ul>
    </div>
    <div class="row">

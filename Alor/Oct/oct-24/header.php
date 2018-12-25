<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1"/>
    <meta name="format-detection" content="telephone=no"/>
    <title><?php wp_title(' | ', true, 'right'); ?></title>

    <?php if (is_singular()) wp_enqueue_script('theme-comment-reply', get_template_directory_uri() . "/js/comment-reply.js"); ?>
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_head(); ?>

    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.main.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.bxslider.js"></script>	
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <!--[if IE]><script type="text/javascript" src="<?php // echo get_template_directory_uri(); ?>/js/ie.js"></script><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie.css" /><![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/custom.css"/>
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favourit-icon-black.png" type="image/png"
          sizes="22x20">
    <script type="text/javascript">
        function thank_page(args) {
            location = '<?php echo get_page_link(thankyouPageId); ?>';
        }
    </script>
</head>



<body class="inner_cls">



<?php echo '<!-- ' . basename(get_page_template()) . ' -->'; ?>

<!-- Google Tag Manager -->
<noscript>
    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-NZQF3F"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            '//www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NZQF3F');</script>
<!-- End Google Tag Manager -->

<noscript>
    <div>Javascript must be enabled for the correct page display</div>
</noscript>
<div class="skip"><a href="#content" accesskey="S">Skip to Content</a></div>
<div id="wrapper">
    <div class="w1">
        <div class="w2">
            <?php get_template_part('header', 'desktop'); ?>
            <?php get_template_part('header', 'mobile'); ?>
            <?php get_template_part('template', 'banner'); ?>
                                



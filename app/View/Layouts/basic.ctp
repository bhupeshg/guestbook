<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('style');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-responsive.min');
    echo $this->Html->css('font-awesome.min');
	echo $this->Html->css('datepicker');
	?>

    <!--[if IE 7]>
    <?php echo $this->Html->css('font-awesome-ie7.min'); ?>
    <![endif]-->

    <?php

    echo $this->Html->css('ace-fonts');
    echo $this->Html->css('ace.min');
    echo $this->Html->css('ace-rtl.min');
    echo $this->Html->css('ace-skins.min');
    ?>
    <!--[if lte IE 8]>
    <?php echo $this->Html->css('ace-ie.min'); ?>
    <![endif]-->

    <!-- inline styles related to this page -->
    <?php echo $this->Html->script('jquery.min');?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <?php echo $this->Html->script('ace-extra.min'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#overlay_img').css({
				opacity : 0.5,
				width   : $(window).innerWidth(),
				height  : $(window).innerHeight(),
				'z-index' : '9999',
			});

			$('#busy-indicator').css({
				top  : ($(window).height() / 2),
				left : ($(window).width() / 2)
			});
		});
	</script>
</head>
<body>
	<div id="overlay_img">
		<?php echo $this->Html->image(
			'ajax-loader.gif',
			array('id' => 'busy-indicator')
		); ?>
	</div>
    <div class="navbar" id="navbar">
        <?php echo $this->element('header');?>
    </div>
    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.check('main-container', 'fixed')
            } catch (e) {
            }
        </script>

        <div class="main-container-inner">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>
            <div class="sidebar" id="sidebar">
                <?php echo $this->element('left');?>
            </div>

            <div class="main-content">
                <div id="showFlasshMsgsDiv">
                    <div class="alert in alert-block fade">
                        <a data-dismiss="alert" class="close" href="#">×</a>
                        <?php echo $this->Session->flash();?>
                    </div>
                </div>
                <div class="breadcrumbs" id="breadcrumbs">
                    <?php echo $this->element('breadcrumbs');?>
                </div>

                <div class="page-content" id="content">
                    <?php echo $content_for_layout; ?>
                </div>
                <!-- /.page-content -->
            </div>
            <!-- /.main-content -->
            <div class="ace-settings-container" id="ace-settings-container">
                <?php echo $this->element('ace_settings');?>
            </div>
            <!-- /#ace-settings-container -->
        </div>
        <!-- /.main-container-inner -->
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="icon-double-angle-up icon-only bigger-110"></i>
        </a>
    </div>
    <!-- /.main-container -->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='/guestbook/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/guestbook/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/guestbook/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>


    <!-- basic scripts -->
    <!--[if !IE]> -->
    <?php echo $this->Html->script('jquery-2.0.3.min'); ?>
    <!-- <![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='/guestbook/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->


    <!--[if IE]>
    <?php echo $this->Html->script('jquery-1.10.2.min'); ?>
    <![endif]-->

    <script type="text/javascript">
        if ("ontouchend" in document) document.write("<script src='<?php echo SITE_URL; ?>/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>



    <?php
    echo $this->Html->script('bootstrap.min');
    ?>
    <!--<script src="assets/js/typeahead-bs2.min.js"></script>-->

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
    <!--<script src="assets/js/excanvas.min.js"></script>-->
    <![endif]-->

    <!-- ace scripts -->
    <?php
	echo $this->Html->script('jquery-ui-1.10.3.custom.min');
	echo $this->Html->script('date-time/bootstrap-datepicker.min');
	/*echo $this->Html->script('chosen.jquery.min');
	echo $this->Html->script('fuelux/fuelux.spinner.min');
	echo $this->Html->script('date-time/bootstrap-datepicker.min');
	echo $this->Html->script('jquery.autosize-min');
	echo $this->Html->script('jquery.inputlimiter.1.3.1.min');
	echo $this->Html->script('jquery.maskedinput.min');*/
    echo $this->Html->script('ace-elements.min');
    echo $this->Html->script('ace.min'); ?>

</body>
</html>
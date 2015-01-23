<div class="center">
    <h1>
        <i class="icon-leaf green"></i>
        <span class="red">GuestBook</span>
        <!--<span class="white">Application</span>-->
    </h1>
    <!--<h4 class="blue">&copy; Company Name</h4>-->
</div>
<div class="space-6"></div>
<div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <div class="space-6"></div>
                <div id="loginStatus">
                    <?php echo $this->Session->flash();?>
                </div>
                <?php echo $this->element('Users/switch_lawyer');?>
            </div>
            <!-- /widget-main -->
        </div>
        <!-- /widget-body -->
    </div>
    <!-- /login-box -->
    <!-- /forgot-box -->
</div><!-- /position-relative -->
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
    <div id="forgot-box" class="forgot-box widget-box no-border visible">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header red lighter bigger">
                    <i class="icon-key"></i>
                    Retrieve Password
                </h4>

                <div class="space-6"></div>
                <p>
                    Enter your email and to receive instructions
                </p>

                <form>
                    <fieldset>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="email" class="form-control" placeholder="Email" />
                                <i class="icon-envelope"></i>
                            </span>
                        </label>

                        <div class="clearfix">
                            <?php echo $this->Form->button('<i class="icon-lightbulb"></i> Send Me!', array('type' => 'button', 'class' => 'width-35 pull-right btn btn-sm btn-danger'),array('escape'=>false)); ?>
                        </div>
                    </fieldset>
                </form>
            </div><!-- /widget-main -->

            <div class="toolbar center">
                <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                    Back to login
                    <i class="icon-arrow-right"></i>
                </a>
                <?php echo $this->Html->link('Back to login <i class="icon-arrow-right"></i>', array('controller' => 'users', 'action' => 'forgotPassword'), array('class' => 'forgot-password-link'),array('escape'=>false))?>
            </div>
        </div><!-- /widget-body -->
    </div><!-- /forgot-box -->
</div><!-- /position-relative -->
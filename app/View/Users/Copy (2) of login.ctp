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
        <?php
        $data = $this->Js->get('#UserLoginForm')->serializeForm(array('isForm' => true, 'inline' => true));
        $this->Js->get('#UserLoginForm')->event(
            'submit',
            $this->Js->request(
                array('action' => 'login'),
                array(
                    'update' => '#login-container',
                    'data' => $data,
                    'async' => true,
                    'dataExpression'=>true,
                    'method' => 'POST'
                )
            )
        );

        echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login")));
        /*echo $this->Form->create('User',array(
            'type' => 'post',
            'action' => 'userAction',
            'onSubmit' => 'return false;'
        ));*/
        echo $this->Form->hidden("action", array("value" => "login"));
        echo $this->Form->hidden("token", array("value" => $token));
        ?>
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="icon-coffee green"></i>
                    Please Enter Your Information
                </h4>

                <div class="space-6"></div>
                <div id="loginStatus">
                    <?php echo $this->Session->flash();?>
                </div>
                <fieldset>
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php echo $this->Form->input("login_email", array("class" => "form-control","required" => "required","placeholder" => "Email","label"=>"Email"));?>
                                <i class="icon-user"></i>
                            </span>
                    </label>

                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php echo $this->Form->input("user_pwd", array("class" => "form-control","required" => "required", "placeholder" => "Password", "type" => "password","label"=>"Password"));?>
                                <i class="icon-lock"></i>
                            </span>
                    </label>

                    <div class="space"></div>

                    <div class="clearfix">
                        <label class="inline">
                            <input type="checkbox" class="ace"/>
                            <!--<span class="lbl"> Remember Me</span>-->
                        </label>

                        <?php
                        /*echo $this->Js->submit('Login', array(
                            'before'=>$this->Js->get('#sending')->effect('fadeIn'),
                            'success'=>$this->Js->get('#sending')->effect('fadeOut'),
                            'update'=>'#success',
                            "class"=>"width-35 pull-right btn btn-sm btn-primary",
                            "escape"=>false,
                        ));*/
                        echo $this->Form->button("<i class='icon-key'></i>Login",
                            array("class"=>"width-35 pull-right btn btn-sm btn-primary","escape"=>false,
                                "type"=>"submit"));

                        echo $this->Js->writeBuffer();
                        ?>
                    </div>
                    <!--<div id="sending" style="display: none; background-color: lightgreen;">Sending...</div>-->
                    <div class="space-4"></div>
                </fieldset>
            </div>
            <!-- /widget-main -->

            <div class="toolbar clearfix">
                <div>
                    <?php echo $this->Html->link("<i class='icon-arrow-left'></i> I forgot my password", array(), array('class' => 'forgot-password-link', 'onclick' => "show_box('forgot-box'); return false;", "escape" => false))?>
                </div>
            </div>
        </div>
        <!-- /widget-body -->
        <?php echo $this->Form->end();?>
    </div>
    <!-- /login-box -->
    <div id="forgot-box" class="forgot-box widget-box no-border">
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

                <?php
                $data = $this->Js->get('#forgotPassword')->serializeForm(array('isForm' => true, 'inline' => true));
                $this->Js->get('#forgotPassword')->event(
                    'submit',
                    $this->Js->request(
                        array('action' => 'login'),
                        array(
                            'update' => '#login-container',
                            'data' => $data,
                            'async' => true,
                            'dataExpression'=>true,
                            'method' => 'POST'
                        )
                    )
                );
                echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login"), "id" => "forgotPassword")); ?>
                    <fieldset>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php
                                echo $this->Form->hidden("action", array("value" => "forgot"));
                                echo $this->Form->input("forgot_email", array("class" => "form-control","required" => "required","placeholder" => "Email","label"=>"Email"));?>
                                <i class="icon-envelope"></i>
                            </span>
                        </label>

                        <div class="clearfix">
                            <?php echo $this->Form->button('<i class="icon-lightbulb"></i> Send Me!', array('type' => 'submit', 'class' => 'width-35 pull-right btn btn-sm btn-danger'), array('escape' => false));
                            echo $this->Js->writeBuffer();
                            ?>
                        </div>
                    </fieldset>
                <?php echo $this->Form->end();?>
            </div>
            <!-- /widget-main -->

            <div class="toolbar center">

                <?php echo $this->Html->link('Back to login <i class="icon-arrow-right"></i>', array(), array('class' => 'back-to-login-link', 'onclick' => "show_box('login-box'); return false;", 'escape' => false))?>
            </div>
        </div>
        <!-- /widget-body -->
    </div>
    <!-- /forgot-box -->
</div><!-- /position-relative -->
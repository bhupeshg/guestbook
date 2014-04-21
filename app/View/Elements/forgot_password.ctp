<?php echo $this->element('Users/forgot_password');?>
    <h4 class="header red lighter bigger">
        <i class="icon-key"></i>
        Retrieve Password
    </h4>

    <div class="space-6"></div>
    <p>
        Enter your email and to receive instructions
    </p>
<?php echo $this->Session->flash();?>
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
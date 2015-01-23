<h4 class="header red lighter bigger">
    <i class="icon-key"></i>
    Switch Lawyer
</h4>
<div class="space-6"></div>
<?php echo $this->Session->flash();?>
<?php
echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "switchLawyer"), "id" => "switchLawyer")); ?>
    <fieldset>
        <label class="block clearfix">
			<span class="block input-icon input-icon-right">
                <?php echo $this->Form->input('lawyer_id', array('options' => $listLawyers, 'empty' => '--Select Lawyer--', 'label' => false, 'div' => false, 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Country', 'class' => 'form-control')); ?>
			</span>
        </label>

        <div class="clearfix">
            <?php echo $this->Form->button('<i class="icon-lightbulb"></i> Submit!', array('type' => 'submit', 'class' => 'width-35 pull-right btn btn-sm btn-danger'), array('escape' => false));
            echo $this->Js->writeBuffer();
            ?>
        </div>
    </fieldset>
<?php echo $this->Form->end();?>
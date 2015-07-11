<?php //echo $this->Html->css('dropzone'); ?>
<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('ClientCase', array('url' => '/cases/addHearing/'.$caseId.'/'.$id, 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
			<?php echo $this->Form->input('CaseHearing.client_id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>
			<?php echo $this->element('Cases/add_hearing');?>
			<div class="col-sm-12 col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-info", "escape" => false, "type" => "submit"));?>
						&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset">
							<i class="icon-undo bigger-110"></i>
							Reset
						</button>
					</div>
				</div>

				<div class="hr hr-18 dotted hr-double"></div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div class="col-sm-12 col-xs-12">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">Hearing Details</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row">
					<?php echo $this->Form->input('CaseHearing.next_hearing_date', array('label' => false, 'div' => false, 'type' => 'hidden', 'error' => false)); ?>

					<?php if(!empty($nextHearingDate)) { ?>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12 col-xs-12">
								<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Next Hearing: </label>
								<label class="col-sm-8 col-xs-12" style="padding-top:7px;">
									<?php echo $nextHearingDate; ?>
								</label>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if(!empty($previousHearingDate)) { ?>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12 col-xs-12">
								<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Previous Hearing: </label>
								<label class="col-sm-8 col-xs-12" style="padding-top:7px;">
									<?php echo $previousHearingDate;
									//echo $this->Form->input('CaseHearing.previous_hearing_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Previous Hearing Date', 'id' => 'date-timepicker1', "readonly" => true)); ?>
								</label>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12 col-xs-12">
								<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Date: </label>
								<div class="col-sm-8">
									<?php echo $this->Form->input('CaseHearing.id', array('label' => false, 'div' => false, 'error' => false)); ?>
									<?php echo $this->Form->input('CaseHearing.date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Hearing Date', 'id' => 'date-timepicker-hearing-date', "readonly" => true)); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12 col-xs-12">
								<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Judge: </label>
								<div class="col-sm-8">
									<?php echo $this->Form->input('CaseHearing.judge', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Judge Name')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<div class="col-sm-12 col-xs-12">
								<label class="col-sm-2 col-xs-12 control-label no-padding-right" for="form-field-dob">Notes: </label>
								<div class="col-sm-10">
									<?php echo $this->Form->input('CaseHearing.notes', array('label' => false, 'div' => false, 'type' => 'textarea', 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Case Notes', 'rows' => '3')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#date-timepicker-hearing-date, #date-timepicker-next-hearing-date').datetimepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	});
</script>

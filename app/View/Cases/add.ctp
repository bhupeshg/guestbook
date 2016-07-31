<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('ClientCase', array('url' => '/cases/add/'.$caseId, 'class' => 'form-horizontal dropzone', 'name' => 'add', 'id' => 'add')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Case Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Case Title: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'error' => false)); ?>
											<?php echo $this->Form->input('ClientCase.title', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Title', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Court Case Number: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Case Number', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Reference Number: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.ref_number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Reference Number', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Court: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.court', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Court', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Case Type: </label>
										<div class="col-sm-8">
											<?php
											$caseType = array('Case' => 'Case', 'Notice' => 'Notice', 'PIL' => 'PIL');
											echo $this->Form->input('ClientCase.type', array('options' => $caseType, 'empty' => '--Select Type--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off', 'data-placeholder' => 'Choose Case type', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Case Stage: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.stage', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Stage', "required" => "required")); ?>
										</div>
									</div>
								</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Fee Settled: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.fee_settled', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Fee Settled')); ?>
										</div>
									</div>
								</div>
                        	</div>
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Filing Date: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.filing_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Filing Date', 'data-date-format' => 'yyyy-mm-dd')); ?>
										</div>
									</div>
								</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Referred By (Optional): </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.referred_by', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Referred By')); ?>
										</div>
									</div>
								</div>
                        	</div>
                        	<div class="col-sm-6">
                        		<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Case Description: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.description', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Description', 'rows' => '3')); ?>
										</div>
									</div>
								</div>
                        	</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Client Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Select Client: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.client_id', array('options' => $listClients, 'empty' => '--Select--', 'label' => false, 'div' => false, 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Client', 'class' => 'select2 col-sm-12')); ?>
											<?php echo $this->Html->link('Add Client', "javascript:void(0)", array('escape' => false, 'data-toggle' => 'modal', 'data-target' => '#myModal')); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Representing: </label>
										<div class="col-sm-8">
											<div class="radio">
												<?php
												$caseTypeOptions = array('Petitionar','Defendant');
												foreach($caseTypeOptions as $caseTypeOption)
												{
												$checked = (!empty($this->request->data['ClientCase']['representing'])
															&& $this->request->data['ClientCase']['representing'] == $caseTypeOption)
															? 'checked="checked"'
															: ''

												?>
												<label>
													<input name="data[ClientCase][representing]" type="radio" <?php echo $checked; ?> class="ace" required="required" value="<?php echo $caseTypeOption; ?>" />
													<span class="lbl"> <?php echo $caseTypeOption; ?></span>
												</label>&nbsp;
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Name: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.client_first_name', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-6 col-xs-6', 'placeholder' => 'First Name', "required" => "required")); ?>
											<?php echo $this->Form->input('ClientCase.client_last_name', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-6 col-xs-6', 'placeholder' => 'Last Name', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Email: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.client_email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Email', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-phone">Phone Number: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.client_phone_number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Phone Number', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-alternate-number">Alternate Number: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.client_alternate_number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Alternate Number')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Opponent Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">First Name: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_first_name', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Title', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Last Name: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_last_name', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Case Number', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Lawyer: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_lawyer', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Lawyer', "required" => "required")); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-email">Phone Number: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_phone_number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Phone Number')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Email: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Email')); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-dob">Postal Address: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('ClientCase.opponent_postal_address', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Postal Address')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->element('Cases/payments');?>
		<?php echo $this->element('Cases/documents');?>

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
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<div id="add_quick_client">
	<?php echo $this->element('Users/add_quick_client');?>
</div>
<!-- page specific plugin scripts -->

<script type="text/javascript">

	$(document).ready(function(){

		$('.select2').css('width','100%').select2();

		$('#ClientCaseClientId').on('change', function(){
			var client_id = $(this).val();
			if(client_id != '')
			{
				$.ajax({
					dataType: "json",
					type: "GET",
					url: '<?php echo Router::url(array('controller'=>'cases','action'=>'getClientDetails'));?>/'+client_id,
					success: function (data){
						$.each(data, function(i, item) {
							$('#'+i).val(item);
                        })
					}
				});
			}
		});

		$('#saveQuickClient').on('click', function(){
			$.ajax({
				url: $('#addQuickClient').attr('action'),
				type:"POST",
				data: $('#addQuickClient').serialize(),
				dataType:'json',
				success: function(data) {
					$('.addQuickClientError').hide();
					if(data.status=='error') {

						$.each(data.message, function (i, v) {

							if($('#error_'+i).length > 0) {

								$('#error_'+i).html(v);
								$('#error_'+i).show();
							}
                        });
					} else if(data.status=='success') {

                        var $el = $("#ClientCaseClientId");
                        $el.empty(); // remove old options
                        $.each(data.clients, function(key,value) {
                          $el.append($("<option></option>")
                             .attr("value", key).text(value));
                        });

						$('#myModal').modal('hide');
					}
				}
			});
		});
	});
</script>
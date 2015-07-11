<div class="col-sm-12 col-xs-12">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">Payments</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row" style="margin-left: -13px !important;">
					<div class="payment_form_cnt col-xs-12">
						<table id="simple-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Date</th>
									<th>Amount</th>
									<th>Type</th>
									<th>Notes</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr style="display: none" class="form-fields">
									<td>
										<?php echo $this->Form->input('CasePayment.date][', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'Payment Date', 'data-date-format' => 'yyyy-mm-dd', "class" => "form-control date-picker")); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.amount][', array('label' => false, 'type' => 'number', 'div' => false, 'placeholder' => 'Amount', "class" => "form-control case_payment_value", "autocomplete" => "off")); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.type][', array('options' => array('Cash' => 'Cash', 'Cheque' => 'Cheque'), 'empty' => '--Select Type--', 'label' => false, 'div' => false, 'class' => 'col-md-12')); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.notes][', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'Notes', "class" => "form-control")); ?>
									</td>
									<td class="remove"></td>
								</tr>
								<?php
								$case_settled_fee = (!empty($this->request->data['ClientCase']['fee_settled'])) ? $this->request->data['ClientCase']['fee_settled'] : 0;
								$amount_paid = 0;
								if(!empty($case_payments)){
									foreach($case_payments as $case_payment){
										$amount_paid = $amount_paid+$case_payment['amount'];
										?>
										<tr>
											<td><?php echo $case_payment['date'];?></td>
											<td><?php echo number_format((float)$case_payment['amount'], 2, '.', '');?></td>
											<td><?php echo $case_payment['type'];?></td>
											<td><?php echo $case_payment['notes'];?></td>
											<td>
												<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'deletePayment',$case_payment['id'],$case_payment['case_id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this payment?")?>
											</td>
										</tr>
								<?php } } ?>
								<tr class="form-fields">
									<td>
										<?php echo $this->Form->input('CasePayment.date][', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'Payment Date', 'data-date-format' => 'yyyy-mm-dd', "class" => "form-control date-picker")); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.amount][', array('label' => false, 'type' => 'number', 'div' => false, 'placeholder' => 'Amount', "class" => "form-control case_payment_value", "autocomplete" => "off")); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.type][', array('options' => array('Cash' => 'Cash', 'Cheque' => 'Cheque'), 'empty' => '--Select Type--', 'label' => false, 'div' => false, 'class' => 'col-md-12')); ?>
									</td>
									<td>
										<?php echo $this->Form->input('CasePayment.notes][', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'Notes', "class" => "form-control")); ?>
									</td>
									<td class="remove"></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<span class="add"><a href="javascript:void(0)">(+) Add More</a></span>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<div class="col-sm-4 col-xs-12">
								<label class="col-sm-6 col-xs-12 no-padding-top control-label"><b>Fee Settled:</b> </label><div class="col-sm-6" id="fee_settled">Rs <?php echo number_format((float)$case_settled_fee, 2, '.', '');?></div>
							</div>
							<div class="col-sm-4 col-xs-12">
								<label class="col-sm-6 col-xs-12 no-padding-top control-label"><b>Fee Paid:</b> </label><div class="col-sm-6" id="fee_paid">Rs <?php echo number_format((float)$amount_paid, 2, '.', '');?></div>
							</div>
							<div class="col-sm-4 col-xs-12">
								<label class="col-sm-6 col-xs-12 no-padding-top control-label"><b>Balance:</b> </label><div class="col-sm-6" id="balance_fee">
								Rs <?php $balance_fee = $case_settled_fee - $amount_paid;
								echo number_format((float)$balance_fee, 2, '.', '');?>
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
		$('.add a').click(function(){
			$('.form-fields:first')
				.clone()
				.insertAfter('.form-fields:last');

			$('.form-fields:last .remove').html('<a href="javascript:void(0)"> <i class="icon-trash bigger-130"></i></a>');
			$('.form-fields:last').show();
		});

		$("body").delegate( ".remove a", "click", function(event){
			$(this).closest("tr").remove();
		});

		$('.remove_payment a').click(function(){
			$('.payment_form_cnt').hide();
		});

		$("body").delegate( "#ClientCaseFeeSettled, .case_payment_value", "keyup", function(event){
			var amount_paid = parseFloat('<?php echo $amount_paid; ?>');
            var gross_total = parseFloat($('#ClientCaseFeeSettled').val());
            var gross_payments = parseFloat(0);
			if($.isNumeric($(this).val()))
			{
				$(".form-fields").each(function(i){
					var payment = parseFloat($(this).find('.case_payment_value').val());
					if(payment != '' && $.isNumeric(payment))
					{
						gross_payments = parseFloat(gross_payments) + parseFloat(payment);
					}
				});

				amount_paid = amount_paid + parseFloat(gross_payments);
			}
			var total_amount_to_pay = gross_total - amount_paid;

			$('#fee_settled').html('Rs '+gross_total.toFixed(2));
			$('#fee_paid').html('Rs '+amount_paid.toFixed(2));
			$('#balance_fee').html('Rs '+total_amount_to_pay.toFixed(2));
		});
	});
</script>
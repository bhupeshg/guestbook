<div class="page-header position-relative">
	<h1>
		Lawyer Management
		<small>
			<i class="icon-double-angle-right"></i>
			Add Lawyer
		</small>
	</h1>
</div><!-- /.page-header -->

<div class="row-fluid">
	<div class="span12">
		<!-- PAGE CONTENT BEGINS -->
		<?php
        echo $this->Html->script('formvalidation');
        echo $this->Form->create('User', array('url' => '/admins/addLawyer', 'class' => 'form-horizontal','name'=>'addLawyer', 'id'=>'addLawyer')); ?>
		<div class="control-group">
			<label class="control-label" for="form-field-1">First Name</label>
			<div class="controls">
				<?php echo $this->Form->input('User.first_name', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'First Name', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Last Name</label>
			<div class="controls">
				<?php echo $this->Form->input('User.last_name', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Last Name', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">DOB</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.dob', array('label' => false, 'type' => 'text', 'div' => false, 'class' => 'date-picker', 'placeholder' => 'DOB', 'id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy', "required" => "required")); ?>
				<span class="add-on">
					<i class="icon-calendar"></i>
				</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Mobile</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.mobile', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Mobile')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Email</label>
			<div class="controls">
				<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Email', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Password</label>
			<div class="controls">
				<?php echo $this->Form->input('User.user_pwd', array('label' => false, 'div' => false, 'class' => '', 'type' => 'password', 'placeholder' => 'Password', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Confirm Password</label>
			<div class="controls">
				<?php echo $this->Form->input('User.confirm_password', array('label' => false, 'div' => false, 'class' => '', 'type' => 'password', 'placeholder' => 'Confirm Password', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Address 1</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.street_address_1', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Address 1')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Address 2</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.street_address_2', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Address 2')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Country</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.country', array('options' => array('1'=>'India'), 'empty' => '--Select Country--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Country')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">State</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.state', array('options' => array('1'=>'Punjab'), 'empty' => '--Select State--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a State')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">City</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.city', array('options' => array('1'=>'Chandigarh'), 'empty' => '--Select City--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a City')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Zip</label>
			<div class="controls">
				<?php echo $this->Form->input('Profile.zip', array('label' => false, 'div' => false, 'class' => '', 'placeholder' => 'Zip')); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Select Plan</label>
			<div class="controls">
				<?php echo $this->Form->input('UserTransaction.plan_id', array('options' => $listPlans, 'empty' => '--Select Plan--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Plan', "required" => "required")); ?>
                &nbsp;<span id="planAmount"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Any Discount</label>
			<div class="controls anyDiscount">
				<?php
        $options = array('y' => 'Yes', 'n' => 'No');
        echo $this->Form->radio('UserTransaction.any_discount', $options, array('legend' => false,'default' => 'n','class' => 'anyDiscount', "required" => "required")); ?>
			</div>
		</div>
		<div class="control-group" id="addDiscount" style="display: none;">
			<label class="control-label" for="form-field-1">Discount</label>
			<div class="controls">
			  <?php echo $this->Form->input('UserTransaction.discount_value', array('label' => false, 'div' => false, 'class' => '')); ?>
				<?php echo $this->Form->input('UserTransaction.discount_type', array('options' => Configure::read('DISCOUNT_TYPES'), 'empty' => '--Discount Type--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose Discount Type')); ?>
			</div>
		</div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Mode of Payment</label>
            <div class="controls">
                <?php echo $this->Form->input('UserTransaction.transaction_id', array('options' => Configure::read('PAYMENT_TYPES'), 'empty' => '--Payment Type--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose Discount Type')); ?>
                <?php echo $this->Form->input('UserTransaction.transaction_id', array('label' => false, 'div' => false, 'class' => '', 'type' => 'text', 'placeholder' => 'Transaction ID')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Total Amount</label>
            <div class="controls" id="totalAmount">
                $0.00
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Additional</label>
            <div class="controls">
                <?php echo $this->Form->input('UserTransaction.notes', array('label' => false, 'div' => false, 'class' => '')); ?>
            </div>
        </div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">&nbsp;</label>
			<div class="controls">
				<?php echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Submit", array("class"=>"btn btn-purple btn-small","escape"=>false, "type"=>"submit"));?>
			</div>
		</div>
		<?php echo $this->Form->end();
        //echo $this->Validation->rules(array("User"/*,"Profile"*/), array("formId" => "addLawyer"));
        ?>
	</div>
</div>
<?php
    //echo $this->Html->script('chosen.jquery.min');
    echo $this->Html->script('date-time/bootstrap-datepicker.min');
    echo $this->Html->script('date-time/moment.min');
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#UserTransactionDiscountType').on('change', function(){
            updateTotalPayment();
        })

        $('#UserTransactionDiscountType').on('focus', function(){
            updateTotalPayment();
        })

        $('#UserTransactionPlanId').on('change', function(){
            var planDetail = $('#UserTransactionPlanId').val();
            var planValue = planDetail.split("_").pop();
            var showPlanValue = '';
            if(planValue!=''){
                showPlanValue = '$'+planValue;
            }
            $('#planAmount').html(showPlanValue);
            updateTotalPayment();
        })

        $('.anyDiscount').on('click', function(){
            var anyDiscount = $(".anyDiscount:checked").val();
            if(anyDiscount=='y'){
                $('#addDiscount').show();
            }else{
                $('#addDiscount').hide();
            }
        })

        $('#id-disable-check').on('click', function() {
            var inp = $('#form-input-readonly').get(0);
            if(inp.hasAttribute('disabled')) {
                inp.setAttribute('readonly' , 'true');
                inp.removeAttribute('disabled');
                inp.value="This text field is readonly!";
            }
            else {
                inp.setAttribute('disabled' , 'disabled');
                inp.removeAttribute('readonly');
                inp.value="This text field is disabled!";
            }
        });

        //$(".chosen-select").chosen();

        /*$('.date-picker').datepicker().next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        $('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function(){
            $(this).next().focus();
        });*/

    });

    function updateTotalPayment(){
        var planDetail = $('#UserTransactionPlanId').val();
        var planValue = planDetail.split("_").pop();
        var showNetAmount = '';
        if(planValue!=''){
            showNetAmount = planValue;
            var discountType = $('#UserTransactionDiscountType').val();
            var discountValue = $('#UserTransactionDiscountValue').val();
            if(discountType!='' && discountValue!=''){
               if(discountType==1){
                   showNetAmount = (parseFloat(planValue)-parseFloat(discountValue)).toFixed(1);
               }else if(discountType==2){
                   netDiscount = (parseFloat(discountValue)/parseInt(100)*parseFloat(planValue));
                   showNetAmount = parseFloat(planValue)-parseFloat(netDiscount).toFixed(1);
               }
            }
        }
        $('#totalAmount').html('$'+showNetAmount);
    }
</script>
<?php
echo $this->Html->css('datepicker');
//echo $this->Html->script('date-time/bootstrap-datepicker.min'); ?>
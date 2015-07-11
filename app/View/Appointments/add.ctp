<!--<style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
  <script>
  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

    $( "#CaseClientFirstName" ).autocomplete({
      source: "/guestbook/users/listClients",
      minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );
      }
    });
  });
</script>-->
<div class="page-content">
    <div class="page-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
    </div>
    <!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create('Appointment', array('action' => 'add', 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Client </label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('Appointment.client_id', array('options' => $listClients, 'empty' => '--Select Client--', 'label' => false, 'div' => false, 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Client', 'class' => 'col-xs-10 col-sm-5 select2')); ?>
                </div>
            </div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Date & Time </label>
				<div class="col-sm-4">
					<div class='input-group date' id='datetimepicker1'>
						<?php echo $this->Form->input('Appointment.datetime', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'Date & Time', 'id' => 'date-timepicker1', "class" => "form-control", "required" => "required", "readonly" => true)); ?>
						<span class="input-group-addon">
							<i class="icon-calendar bigger-110"></i>
						</span>
				  	</div>
				</div>
			</div>
			<div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Notes</label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('Appointment.notes', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Notes')); ?>
                </div>
            </div>
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
            <?php echo $this->Form->end(); ?>
            <div class="hr hr-18 dotted hr-double"></div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').css('width','100%').select2();

		$('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

		/*$("select2").select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: URL,
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.completeName,
                                slug: item.slug,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });*/


	})
</script>
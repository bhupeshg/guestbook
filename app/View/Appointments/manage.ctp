<?php
//echo $this->Html->script('jquery'); // Include jQuery library
echo $this->Html->script('listing'); ?>
<?php $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); ?>
<div class="page-header position-relative">
    <h1>
        Manage Appointments
    </h1>
</div><!-- /.page-header -->

<?php 
$data = $this->Js->get('#listAppointmentForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#listAppointmentForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manage'),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('Appointment',array('action' => 'manage','id'=>'listAppointmentForm','name'=>'listAppointmentForm')); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
						<span><?php echo $this->Form->input('Appointment.date', array('label' => false, 'required' => false, 'div' => false, 'placeholder' => 'Date', 'data-date-format' => 'yyyy-mm-dd', 'id' => 'id-date-picker-1', "class" => "input-medium search-query date-picker")); ?></span>
						<span><?php echo $this->Form->input('Client.name', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client name','required' => false)); ?></span>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-small","escape"=>false,
                                "type"=>"submit"));
						echo $this->Js->writeBuffer(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row-fluid">
<div class="span12">
<!-- PAGE CONTENT BEGINS -->
        <div class="row-fluid">

        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
        <div class="row-fluid">
            <div class="span6">
                <div id="sample-table-2_length" class="dataTables_length"><label>
                        Display
                        <?php
                        $pagingLimitOptions = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100');
                        echo $this->Form->input('Appointment.paging_limit',array('id'=>'paging_limit','type' =>'select', 'options'=>$pagingLimitOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,"onchange"=>"setPagingLimit('listAppointmentForm');","value"=>$paginateLimit)); ?>
                         records</label></div>
            </div>
        </div>
        <table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
               aria-describedby="sample-table-2_info">
        <thead>
        <tr role="row">
            <th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
                <label>
                    <input type="checkbox" class="ace" onclick="changeCheckboxStatus(listAppointmentForm)" name="selectAll" id='checkall'>
                    <span class="lbl"></span>
                </label>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
				<?php echo $this->Paginator->sort('Client.first_name', 'Client Name', array());?>
			</th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
				<?php echo $this->Paginator->sort('Appointment.date', 'Date & Time', array());?>
			</th>
			<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
				<?php echo $this->Paginator->sort('Appointment.fee', 'Consultation Fee', array());?>
			</th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                <!--<i class="icon-time bigger-110 hidden-phone"></i>-->
                <?php echo $this->Paginator->sort('Appointment.created', 'Created', array());?>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
                <?php echo $this->Paginator->sort('Appointment.status', 'Status', array());?>
            </th>
            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label=""></th>
        </tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        <?php $i=($this->params['paging']['Appointment']['page']-1)*LIMIT+1;
        if(isset($records) && !empty($records)){

        	$appointmentStatuses = Configure::read('APPOINTMENT_STATUS');

            foreach ($records as $record){ ?>
            <tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
                <td class="center  sorting_1">
                    <label>
                        <input type="checkbox" class="ace">
                        <input type="checkbox" class="ace" onclick="toggleCheck(listAppointmentForm)" name="box[]" value="<?php echo $record['Appointment']['id']; ?>" >
                        <span class="lbl"></span>
                    </label>
                </td>

                <td class=" ">
                    <?php
                    if(!empty($record['Client']['first_name'])) {
                    	echo $record['Client']['first_name'].' '.$record['Client']['last_name'];
                    }elseif(!empty($record['Appointment']['new_client_name'])) {
                    	echo $record['Appointment']['new_client_name'];
                    }
                    ?>
                </td>
                <td class=" "><?php echo $record['Appointment']['datetime']; ?></td>
                <td class=" ">Rs <?php echo $record['Appointment']['fee']; ?></td>
                <td class="hidden-480 ">
                    <?php echo date(Configure::read('VIEW_DATE_FORMAT'),strtotime($record['Appointment']['created']));?>
                </td>
                <td class="hidden-480 ">
                    <?php $statusClass = ($record['Appointment']['status']==1)?'label-error':'label-success'; ?>
                    <span class="label <?php echo $statusClass; ?>">
                        <?php echo $appointmentStatuses[$record['Appointment']['status']]; ?>
                    </span>
                </td>
                <td class=" ">
                    <div class="hidden-phone visible-desktop action-buttons">

						<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'appointments','action'=>'edit',$record['Appointment']['id']), array('escape' => false, 'class' => 'green'))?>
						
						<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'appointments','action'=>'delete',$record['Appointment']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this appointment?")?>
						
                    </div>

                    <div class="hidden-desktop visible-phone">
                        <div class="inline position-relative">
                            <button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
                                <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                <li>
                                    <a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
                                        <span class="blue">
                                            <i class="icon-zoom-in bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
                                        <span class="green">
                                            <i class="icon-edit bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
                                        <span class="red">
                                            <i class="icon-trash bigger-120"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
                $i++;
            } ?>
            <tFoot>
                <tr role="row">
                    <th role="columnheader" style="border-right: none !important;">
                        <?php
                        $updateStatusOptions = array('Update Status','Pending','Closed');
                        echo $this->Form->input('Appointment.status',array('id'=>'paging_limit','type' =>'select', 'options'=>$updateStatusOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,'id'=>'status',"onchange"=>"updateRecords(this.value,'listAppointmentForm');")); ?>
                    </th>
                    <th role="columnheader" colspan="8" style="border-left: none !important;">
                        <?php if($this->params['paging']['Appointment']['count']>LIMIT){?>
                            <?php echo $this->Element('pagination');?>
                        <?php } ?>
                    </th>
                </tr>
            </tFoot>
        <?php }else{
            ?>
                <tr>
                    <td class="center" colspan="7">
                        <label>
                            <span class="notify_message"><?php echo NO_RECORD;?></span>
                        </label>
                    </td>
                </tr>
            <?php
        }?>
        </tbody>
        </table>
        <!--<div class="row-fluid">
                <div class="span12">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <li class="prev disabled"><a href="#"><i class="icon-double-angle-left"></i></a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li class="next"><a href="#"><i class="icon-double-angle-right"></i></a></li>
                        </ul>
                    </div>
            </div>
        </div>-->
        </div>
        </div>

        <!-- PAGE CONTENT ENDS -->
    </div>
    <!-- /.span -->
</div>
<?php echo $this->Form->end(); ?>
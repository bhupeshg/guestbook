<?php
echo $this->Html->script('listing'); ?>
<?php $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); ?>
<div class="page-header">
	<h1>
		Manage Case Hearings
		<?php if(!empty($caseId)){ ?>
		<div class="col-md-6 col-sm-6 pull-right">
			<?php echo $this->Html->link('Add Hearing', array('controller'=>'cases','action'=>'addHearing',$caseId), array('escape' => false, 'class' => 'btn btn-purple btn-small pull-right'))?>
		</div>
		<?php } ?>
	</h1>
</div>
<?php
$data = $this->Js->get('#casesListForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#casesListForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manageHearings', $caseId),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('CaseHearing',array('url' => '/cases/manageHearings/'.$caseId,'id'=>'casesListForm','name'=>'casesListForm')); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                    	<span><?php echo $this->Form->input('CaseHearing.date', array('label' => false, 'required' => false, 'div' => false, 'type' => 'text', 'placeholder' => 'Hearing Date', 'data-date-format' => 'yyyy-mm-dd', "class" => "input-medium search-query date-picker")); ?></span>
                    	<span><?php echo $this->Form->input('ClientCase.client_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client Name')); ?></span>
                        <span><?php echo $this->Form->input('CaseHearing.judge', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Judge','required' => false)); ?></span>
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
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<div class="row-fluid">
				<div class="span6">
					<div id="sample-table-2_length" class="dataTables_length">
						<label>
							Display
							<?php
							$pagingLimitOptions = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100');
							echo $this->Form->input('CaseHearing.paging_limit',array('id'=>'paging_limit','type' =>'select', 'options'=>$pagingLimitOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,"onchange"=>"setPagingLimit('casesListForm');","value"=>$paginateLimit)); ?>
							 records
						</label>
					</div>
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
			<thead>
			<tr role="row">
				<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
					<label>
						<input type="checkbox" class="ace" onclick="changeCheckboxStatus(casesListForm)" name="selectAll" id='checkall'>
						<span class="lbl"></span>
					</label>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('ClientCase.client_first_name', 'Client Name', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('ClientCase.number', 'Number', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('CaseHearing.judge', 'Judge', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('CaseHearing.date', 'Date', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
					<?php echo $this->Paginator->sort('CaseHearing.status', 'Status', array());?>
				</th>
				<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label=""></th>
			</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
			<?php $i=($this->params['paging']['CaseHearing']['page']-1)*LIMIT+1;
			if(isset($records) && !empty($records)){
				foreach ($records as $record){ ?>
				<tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
					<td class="center  sorting_1">
						<label>
							<input type="checkbox" class="ace">
							<input type="checkbox" class="ace" onclick="toggleCheck(casesListForm)" name="box[]" value="<?php echo $record['CaseHearing']['id']; ?>" >
							<span class="lbl"></span>
						</label>
					</td>
					<td class=" ">
						<?php echo $record['ClientCase']['client_first_name'].' '.$record['ClientCase']['client_last_name'];?>
					</td>
					<td class=" "><?php echo $record['ClientCase']['number']; ?></td>
					<td class=" "><?php echo $record['CaseHearing']['judge']; ?></td>
					<td class=" ">
						<?php
						$dateTime = strtotime($record['CaseHearing']['date']);
                        echo date( 'm/d/Y g:i A', $dateTime);
                        ?>
					</td>
					<td>
						<?php echo $record['CaseHearing']['status']; ?>
					</td>
					<td class=" ">
						<div class="hidden-phone visible-desktop action-buttons">
							<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'addHearing',$record['CaseHearing']['case_id'],$record['CaseHearing']['id']), array('escape' => false, 'class' => 'green'))?>
							<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'deleteHearing',$record['CaseHearing']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this hearing?")?>
						</div>

						<div class="hidden-desktop visible-phone">
							<div class="inline position-relative">
								<button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
									<i class="icon-caret-down icon-only bigger-120"></i>
								</button>

								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
									<li>
										<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'addHearing',$record['CaseHearing']['case_id'],$record['CaseHearing']['id']), array('escape' => false, 'class' => 'green'))?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'deleteHearing',$record['CaseHearing']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this hearing?")?>
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
							$updateStatusOptions = array('Update Status', 'Pending' => 'Pending', 'Attended' => 'Attended', 'Missed' => 'Missed');
							echo $this->Form->input('CaseHearing.status',array('id'=>'paging_limit','type' =>'select', 'options'=>$updateStatusOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,'id'=>'status',"onchange"=>"updateRecords(this.value,'casesListForm');")); ?>
						</th>
						<th role="columnheader" colspan="8" style="border-left: none !important;">
							<?php if($this->params['paging']['CaseHearing']['count']>LIMIT){?>
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
			</div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
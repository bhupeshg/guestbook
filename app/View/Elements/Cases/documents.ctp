<?php echo $this->Html->script('dropzone'); ?>
<?php if(!empty($caseId)){ ?>
<div class="col-sm-12 col-xs-12">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">
				List Files
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
				</small>
			</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2" aria-describedby="sample-table-2_info">
					<thead>
					<tr role="row">
						<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Custom Name
						</th>
						<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							File Name
						</th>
						<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
							Created
						</th>
						<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label=""></th>
					</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php if(!empty($documents)) {
						$i = 0;
						foreach ($documents as $document) { ?>
						<tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
							<td class=" ">
								<?php echo $document['Document']['original_name']; ?>
							</td>
							<td class=" ">
								<?php echo $document['Document']['name']; ?>
							</td>
							<td class=" ">
								<?php echo date(Configure::read('VIEW_DATE_FORMAT'),strtotime($document['Document']['created']));?>
							</td>
							<td class=" ">
								<div class="hidden-phone visible-desktop action-buttons">
									<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'deleteDocument',$document['Document']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this document?")?>
								</div>
							</td>
						</tr>
						<?php $i++; } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-12 col-xs-12">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">
				Upload Files
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
				</small>
			</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row">
					<div class="col-xs-12">
						<div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	var caseId = "<?php echo $caseId; ?>";
    var clientId = "<?php echo (!empty($caseInfo['client_id']) ? $caseInfo['client_id'] : ''); ?>";
	Dropzone.autoDiscover = false;
	$(document).ready(function(){

		$("div#my-awesome-dropzone").dropzone({
			url: "../uploadFiles/" + caseId + "/" + clientId
		}).on('success', function(response) {
          			alert(response)
          			});
	});
</script>
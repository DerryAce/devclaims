<script>
$(document).ready(function(e) {
	//Lead Timing Script
	$(document).on('click','.addTiming',function(){
			var errorfrm='';
			$('#start_time').change(function(){
				$.post('<?=$_SESSION['base_url']?>?r=sales/lead/ajax-lead&id=<?=$_REQUEST['id']; ?>&start_time='+escape($(this).val())+'&eid=<?=$_REQUEST['time_entry_id']; ?>',function(result){
					Remove_Error($('#start_time'));
					if(result>0){
						Add_Error($('#start_time'),'Already have Entry of this timing');
						errorfrm='yes';
						 $('[name="timingSubmit"]').attr('disabled',true);
					}else{
						Remove_Error($('#start_time'));
						 errorfrm='';
						 $('[name="timingSubmit"]').removeAttr('disabled');
					}
				})	
				
				
			$('#end_time').change(function(){
					var error='';
					var start_time = $('#start_time').val();
					var end_time = $('#end_time').val();
					var startTime = new Date(start_time);
					var endTime = new Date(end_time);
					Remove_Error($('#end_time'));
					if(startTime>endTime){
						 error+=Add_Error($('#end_time'),'Start Time Should be Less then Completion Time');
						 $('[name="timingSubmit"]').attr('disabled',true);
					}
					$.post('<?=$_SESSION['base_url']?>?r=sales/lead/ajax-lead-time-date-validation&start_time='+escape(start_time)+'&end_time='+escape(end_time),function(result){
					if(result=='yes'){
						error+=Add_Error($('#end_time'),'You can not use grater then 23 hours');
						 $('[name="timingSubmit"]').attr('disabled',true);
					}else{
						Remove_Error($('#end_time'));
					}
				})
				if(error !=''){
					 $('[name="timingSubmit"]').attr('disabled',true);
				}else{
					Remove_Error($('#end_time'));
					if(errorfrm ==''){
					  $('[name="timingSubmit"]').removeAttr('disabled');
					}
				}
			})
			$('#timingSubmit').click(function(event){
				
					var start_time = $('#start_time').val();
					var end_time = $('#end_time').val();
					var startTime = new Date(start_time);
					var endTime = new Date(end_time);
					var nowD = new Date();
					Remove_Error($('#end_time'));
					Remove_Error($('#start_time'));
					if(startTime > nowD){
						Add_Error($('#start_time'),'You Can not use Future Time');
						event.preventDefault();
					}else{
						if(startTime>endTime){
							 Add_Error($('#end_time'),'Start Time Should be Less then Completion Time');
							 event.preventDefault();
						}else{
							Remove_Error($('#end_time'));
						}
					}
					if(endTime > nowD){
						Add_Error($('#end_time'),'You Can not use Future Time');
						event.preventDefault();
					}else{
						if(startTime>endTime){
							 Add_Error($('#end_time'),'Start Time Should be Less then Completion Time');
							 event.preventDefault();
						}else{
							Remove_Error($('#end_time'));
						}
					}
			})
		});
		 $('.time_form_datetime1').datetimepicker({
			format: 'yyyy/mm/dd hh:ii:ss'
		});
		$('.time_form_datetime2').datetimepicker({
			format: 'yyyy/mm/dd hh:ii:ss'
		});
		$('#timingSubmit').click(function(event){
			var error='';
			$('[data-validation="required"]').each(function(index, element) {
				//alert($(this).attr('id'));
				$(this).removeAttr('style').next('.error').remove();
				if($(this).val() == ''){
					error+=Add_Error($(this),'This Field is Required!');
				}else{
						Remove_Error($(this));							
				}
			});
			$('#cke_5_contents').parent().parent().removeAttr('style').next('.error').remove();
			
			sageLength = CKEDITOR.instances['time_notes'].getData().replace(/<[^>]*>/gi, '').length;
			if(sageLength==0){
				error+=Add_ErrorTag($('#cke_5_contents').parent().parent(),'This Field is Required!');
			event.preventDefault();
			}
			
			
			if(error==''){
				return;	
			}else{
				event.preventDefault();
			}
		})
	})
});
	
</script>
<div class="modal fade lead_timing">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
    	 <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Lead Timing</h4>
        
      </div>
      <div class="modal-body">
			  <form  action="" method="post" enctype="multipart/form-data" name="lead_time" id="lead_time">
              <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
    		<?php if($_GET['time_entry_id']){?>
            	<input type="hidden" name="lead_timing_edit" value="true">
            <?php }else{?>
    			<input type="hidden" name="lead_timing_add" value="true">
            <?php } ?>
        <div class="row">
         	 <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="name">Start Time:*</label>
                    <div class="input-group date time_form_datetime1" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input1">
              		<span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm" name="start_time" id="start_time" value="<?=$timeEntryModel->start_time?>" data-validation="required"/>
               </div>
               		<span class="help-block"></span>
                </div>
            </div>
			 <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Stop Time:*</label>
                    <div class="input-group date time_form_datetime2" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input2">
                     <span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm" name="end_time" id="end_time" value="<?=$timeEntryModel->end_time?>" data-validation="required"/>
               </div>
               		<span class="help-block"></span>
                </div>
            </div>
		</div>
        <div class="row">
                <div class="col-sm-12">
					<div class="form-group">
                    <label class="control-label">Notes:

                    </label>
                    <div class="controls">
                      <textarea class="form-control input-sm ckeditor" name="notes" id="time_notes" rows="8" style="width:100%"><?=$timeEntryModel->notes?></textarea>
                    </div>
                </div>
				</div>
			</div>
<br/>
<div class="form-actions">
		<button class="btn btn-primary" type="submit" name="timingSubmit" id="timingSubmit" value="timingSubmit"/><i class="fa fa-floppy-o"></i> Save</button>
</div>
</form>

		</div>
   </div>
 </div>
</div>
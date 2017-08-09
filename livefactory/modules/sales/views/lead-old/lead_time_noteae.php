<script>
$(document).ready(function(e) {
    $(document).on('click','.stopTime',function(){
		$('#NotesSubmit').click(function(event){
			$('#cke_6_contents').parent().parent().removeAttr('style').next('.error').remove();
			sageLength = CKEDITOR.instances['leadnotes'].getData().replace(/<[^>]*>/gi, '').length;
			if(sageLength==0){
				Add_ErrorTag($('#cke_6_contents').parent().parent(),'This Field is Required!');
			event.preventDefault();
			}
		})
	})
});
	
</script>
<div class="modal fade leadnotes">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
    	 <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Lead Timing Notes</h4>
      </div>
      <div class="modal-body">
			  <form  action="" method="post" enctype="multipart/form-data" name="timeNotes" id="timeNotes">
               <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
        <div class="row">
                <div class="col-sm-12">
					<div class="form-group">
                    <label class="control-label" for="lname">Notes:

                    </label>
                    <div class="controls">
                      <textarea class="form-control input-sm ckeditor" name="leadnotes" id="leadnotes" rows="8" style="width:100%"></textarea>
                    </div>
                </div>
				</div>
			</div>
<br/>
<div class="form-actions">
		<button class="btn btn-primary" type="submit" name="NotesSubmit" id="NotesSubmit" value="timeNotesSubmit"/><i class="fa fa-floppy-o"></i> Save</button>
		<input type="hidden" name="stop_time" value="true"/>
</div>
</form>
		</div>
   </div>
 </div>
</div>
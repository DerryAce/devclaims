<script>

	$(document).ready(function(e) {

        $('.subtask_insert').click(function(event){

			if($('.actual_start_datetime').val()==''){

				$('.actual_start_datetime').val('0000-00-00');

			}

			if($('.actual_end_datetime').val()==''){

				$('.actual_end_datetime').val('0000-00-00');

			}	

		})

    });

</script>

<div class="modal fade taskae">

  <div class="modal-dialog  modal-lg">

    <div class="modal-content">

    	 <div class="modal-header">

        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title"><?=Yii::t('app','Sub Task')?></h4>

      </div>

      <div class="modal-body">

			   <?= $this->render('_form_subtask', [

					'sub_task' => $sub_task,

				]) ?>

		</div>

   </div>

 </div>

</div>

   


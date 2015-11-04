<?php
global $current_year;
global $current_date;
?>
<div id="myModalEnableKeyword" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<?php debug($user_id) ?>
        <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo __('Set Endate to All Keyword'); ?></h3>
        </div>
        <div class="modal-body">
            <?php echo $this->Form->create('Keyword',array('url'=>array('controller'=>'keywords','action'=>'set_all_keyword_enddate'))); ?>
            <?php 
				//echo $this->Form->input('UserID',array('type'=>'hidden','value'=>$this->Session->read('Auth.user.id'))); 
				echo $this->Form->input('UserID',array('type'=>'hidden','value'=> $user_id)); 
				echo $this->Form->input('nocontract',array('type'=>'hidden','value'=>0)); 
			?>
            <table class="table tableX">
                <tr>
                    <th>
                        <?php echo $this->Html->tag('span', __('End Date')); ?>
                    </th>
                    <td>
                        <?php
                        if (empty($this->request->data['Keyword']['rankend']) || $this->request->data['Keyword']['rankend'] == 0) {
                            $this->request->data['Keyword']['rankend'] = $current_date;                            
                        }
						echo $this->Form->input('rankend', array('label' => FALSE, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => $current_year + 1, 'minYear' => $current_year, 'div' => FALSE, 'style' => 'width:auto;'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <?php echo $this->Html->tag('span', __('Reason')); ?>
                    </th>
                    <td>
                        <?php echo $this->Form->input('kaiyaku_reason', array('label' => false, 'type' => 'textarea')); ?>
                    </td>
                </tr>
            </table>
        </div>
		<span class="text-error">※この企業の契約キーワードは全て解約する</span>
        <div class="modal-footer" id="">
		
			<?php echo $this->Form->button(__('Set Endate'), array('class' => 'btn btn-danger')); ?>
        </div>
</div>
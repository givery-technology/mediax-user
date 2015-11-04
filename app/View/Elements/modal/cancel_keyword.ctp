<?php
global $current_year;
global $current_date;
?>
<div id="myModalStatus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo __('Cancel Keyword'); ?></h3>
        </div>
        <div class="modal-body">
            <?php echo $this->Form->create('Keyword'); ?>
            <?php echo $this->Form->input('ID'); ?>
            <table class="table tableX">
                <tr>
                    <th>
                        <?php echo $this->Html->tag('span', __('Cancel Date')); ?>
                    </th>
                    <td>
                        <?php
                        if (empty($this->request->data['Keyword']['rankend']) || $this->request->data['Keyword']['rankend'] == 0) {
                            $this->request->data['Keyword']['rankend'] = $current_date;
                            echo $this->Form->input('rankend', array('label' => FALSE, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => $current_year + 1, 'minYear' => $current_year, 'div' => FALSE, 'style' => 'width:auto;'));
                        } else {
				            if (!empty($this->request->data['Keyword']['rankend']) && $this->request->data['Keyword']['rankend'] != 0) {
				                echo '<div class="cancel_contract">';
				                #The Keyword contract has been cancel
				                echo (!empty($this->request->data['Keyword']['rankend'])) ?
			                        __('Keyword Cancel Date') . ' ' . $this->request->data['Keyword']['rankend'] . ' ' . $this->Form->button(__('Cancel Reset'), array('type' => 'button', 'class' => 'btn btn-danger cancel_keyword', 'value' => $this->request->data['Keyword']['ID'])) :
			                        '';
				                echo '</div>';                        
				            }
						}
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <?php echo $this->Html->tag('span', __('Cancel Reason')); ?>
                    </th>
                    <td>
                        <?php echo $this->Form->input('kaiyaku_reason', array('label' => false, 'type' => 'textarea')); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer" id="">
			<?php echo $this->Form->button(__('Cancel Keyword'), array('class' => 'btn btn-danger')); ?>
        </div>
</div>
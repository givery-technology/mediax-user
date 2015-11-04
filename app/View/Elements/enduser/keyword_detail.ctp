<?php  foreach ($rankhistories as $rankhistory): ?>
<?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
<div class="row">	
	<div class="col-lg-12">
		<div class="box">
			<div class="">
				<h2>
					<span class="not-offer label label-info white-link"><?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID'])); ?></span>
				</h2>
				<span class="align-right">URL:<?php echo $this->Html->link($rankhistory['Keyword']['Url'], $rankhistory['Keyword']['Url'], array('target'=>'_blank','style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?></span>
			</div>
			<div class="box-content">
				<table class="table table-bordered table-striped table-condensed">
					<tbody>
						<tr>
							<td class="">本日の順位</td>
							<td class="">	
								<?php echo $rankhistory['Rankhistory']['Rank'];?>
								<span class=""><?php echo $params['arrow'] ?></span>
							</td>
						</tr>
						<tr>
							<td class="">対策開始日</td>
							<td class="">
								<?php
									foreach ($rankhistory['Keyword']['Duration'] as $duration):
										if(isset($duration['Flag']) && $duration['Flag'] == 1) {
											echo strftime('%Y年%m月%d日', strtotime($duration['StartDate']));	
										} 
									endforeach;
								?>
								<?php echo !isset($rankhistory['Keyword']['Duration'][1])? '-':''; ?>
							</td>
						</tr>
						<tr>
							<td class="">10位以内達成日</td>
							<td class="">
								<?php
									foreach ($rankhistory['Keyword']['Duration'] as $duration):
										if(isset($duration['Flag']) && $duration['Flag'] == 2) {
											echo strftime('%Y年%m月%d日', strtotime($duration['StartDate']));	
										}
									endforeach;
								?>
								<?php echo !isset($rankhistory['Keyword']['Duration'][0])? '-':''; ?>
							</td>
						</tr>
						<tr>
							<td class="">成果対象検索エンジン</td>
							<td class="">
                                <?php
                                    $ENGINE = Configure::read('ENGINE');
                                    echo $ENGINE[$rankhistory['Keyword']['Engine']]; 
                                ?>
                            </td>
						</tr>
					  </tbody>
				 </table>  
			</div>
		</div>
	</div><!--/col-->
</div>
<?php endforeach; ?>
<!--Paginate-->
<!--<div class="pagination pagination-centered">
	<?php if(isset($this->request->params['paging'])): ?>
	<p>
	    <?php
	    echo $this->Paginator->counter(array(
	        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	    ));
	    ?>	</p>

	<div class="pagination pagination-centered">
		<ul class="pagination">
		    <li><?php echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')); ?></li>
		    <li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
		    <li><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')); ?></li>
	    </ul>
	</div>
	<?php endif ?>
</div>  -->
<!--/row-->
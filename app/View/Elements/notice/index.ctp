<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="<?php echo !isset($search) ? 'box': '' ?>">
			<?php if(!isset($search)): ?>
			<div class="box-header">
				<h2>
					<?php echo !isset($search) ? __(ucfirst(Inflector::singularize($this->params['controller'])).' List') : ''; ?> 
					<?php echo !isset($search) ? $this->Paginator->counter(array('format' => __('{:count}'))) : '';?>
				</h2>
			</div>
			<?php endif; ?>
			<div class="box-content">
				<?php echo $this->Session->flash(); ?>
				<table class="table table-striped table-condensed">
					<?php if(!isset($search)): ?>
					<tr>
						<th class="tbl1"><?php echo __('label'); ?></th>
						<th class="tbl4"><?php echo __('title'); ?></th>
					</tr>
					<?php endif; ?>
					<?php foreach ($notices as $notice): ?>
						<tr>
							<td><?php echo $this->Layout->notice_label($notice['Notice']['label']); ?>&nbsp;</td>
							<td>
								<?php 
									echo $this->Html->link(
										$this->Text->truncate($notice['Notice']['title'], 50), 
										'#ModalNotice'.$notice['Notice']['id'],
										array('role'=>'button', 'class'=>'','data-toggle'=>'modal','link'=>Router::url(array('notices'=>true,'controller'=>'notices','action' => 'view_notice', 'id'=>$notice['Notice']['id'])))
									); 
								?>
								<?php echo $this->element('modal/notice_view', array('param'=>$notice['Notice'])); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- paging -->
<div class="row">
	<?php if(!isset($search)): ?>
	<div class="col-lg-12 center">
		<span class="label label-info">
			<?php
				echo $this->Paginator->counter(array(
					'format' => __('全{:pages}ページ')
				));
			?>
		</span>
		<div class="dataTables_paginate paging_bootstrap">
			<ul class="pagination">
				<li><?php echo $this->Paginator->prev('← ' . __('previous'), array(), null, array('class' => 'prev disabled')); ?></li>
				<li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
				<li><?php echo $this->Paginator->next(__('next') . ' →', array(), null, array('class' => 'next disabled')); ?></li>
			</ul>
		</div>
	</div>
	<?php endif ?> 
</div>
<div class="rankhistories view">
<h2><?php  echo __('Rankhistory'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($rankhistory['Rankhistory']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo $this->Html->link($rankhistory['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($rankhistory['Rankhistory']['Url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($rankhistory['Rankhistory']['Rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('RankDate'); ?></dt>
		<dd>
			<?php echo h($rankhistory['Rankhistory']['RankDate']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rankhistory'), array('action' => 'edit', $rankhistory['Rankhistory']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rankhistory'), array('action' => 'delete', $rankhistory['Rankhistory']['ID']), null, __('Are you sure you want to delete # %s?', $rankhistory['Rankhistory']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rankhistories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rankhistory'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>

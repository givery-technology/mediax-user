<div class="contactuses view">
<h2><?php  echo __('Contactus'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contactus['Contactus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($contactus['Contactus']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body'); ?></dt>
		<dd>
			<?php echo h($contactus['Contactus']['body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contactus['User']['name'], array('controller' => 'users', 'action' => 'view', $contactus['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($contactus['Contactus']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($contactus['Contactus']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contactus'), array('action' => 'edit', $contactus['Contactus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contactus'), array('action' => 'delete', $contactus['Contactus']['id']), null, __('Are you sure you want to delete # %s?', $contactus['Contactus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contactuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contactus'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

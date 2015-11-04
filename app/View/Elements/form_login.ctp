<h2><?php echo __('Login'); ?></h2>
<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>

<fieldset>
	<?php echo $this->Session->flash(); ?>

	<div class="control-group">
		<label class="control-label" for="inputEmail"><?php echo __('ID'); ?></label>
		<div class="controls">
			<?php echo $this->Form->input('email',array('label'=> FALSE,'placeholder'=>__('Email'),'id'=>'inputEmail','type'=>'text', 'class' => 'input-large col-xs-12')); ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="inputPassword"><?php echo __('Password'); ?></label>
		<div class="controls">
			<?php echo $this->Form->input('pwd',array('label'=> FALSE,'placeholder'=>__('Password'),'id'=>'inputPassword','type'=>'password', 'class' => 'input-large col-xs-12'));  ?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox"><?php echo $this->Form->input('remember',array('type'=>'checkbox','label'=> FALSE,'div'=> FALSE));  ?><?php echo __('Remember'); ?></label>
			<?php echo $this->Form->button(__('ログイン'), array('class' => 'btn btn-primary col-xs-12')); ?>
		</div>
	</div>
</fieldset>

<?php echo $this->Form->end(); ?>
<hr />
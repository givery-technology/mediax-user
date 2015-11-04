<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
<div class=""><?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::err($this); ?></div>
<div class="control-group">
<label class="control-label" for="inputEmail"><?php echo __('ID'); ?></label>
<div class="controls">
<?php echo $this->Form->input('email',array('label'=> FALSE,'placeholder'=>__('Email'),'id'=>'inputEmail','type'=>'text')); ?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword"><?php echo __('Password'); ?></label>
<div class="controls">
<?php echo $this->Form->input('password',array('label'=> FALSE,'placeholder'=>__('Password'),'id'=>'inputPassword','type'=>'password'));  ?>
</div>
</div>
<div class="control-group">
<div class="controls">
<label class="checkbox"><?php echo $this->Form->input('remember',array('type'=>'checkbox','label'=> FALSE,'div'=> FALSE));  ?><?php echo __('Remember'); ?></label>
<?php echo $this->Form->button(__('ログイン')); ?>
</div>
</div>
<?php echo $this->Form->end(); ?>
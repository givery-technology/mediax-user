<?php $this->assign('title', __(ucfirst(Inflector::singularize($this->params['controller'])).' List'));?>
<?php echo $this->Element('notice/index'); ?>
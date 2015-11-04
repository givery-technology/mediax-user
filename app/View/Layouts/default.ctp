<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<link href='http://fonts.googleapis.com/css?family=Cinzel+Decorative:700' rel='stylesheet' type='text/css'>
	<title><?php echo $this->fetch('title') .' | ' .__('System Name').'X'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->Html->css(array('bootstrap', 'style','font-awesome.min','font-awesome-ie7.min'));
        echo $this->fetch('css');
        echo $this->Html->script(array('jquery-1.10.2.min','bootstrap'));
        echo $this->Html->script(array('highcharts/exporting', 'highcharts/highcharts'));
        echo $this->Html->script(array('count_keyword'));
        echo $this->fetch('script');
        echo $this->Html->css(array('daterangepicker/daterangepicker-bs3'));
        echo $this->Html->script(array('daterangepicker/daterangepicker', 'daterangepicker/moment')); 
    ?>
	<script type="text/javascript">var base_url = '<?php echo $this->webroot ?>';</script>
</head>
<body class="" id="">
<!--Header-->
	<?php echo ($this->Session->read('Auth.User.user') && $this->here!=$this->webroot.'users/login') ? $this->element('header'):''; ?>
<!--Body-->
	<div class="container">
		<div class="row">
<!--Nav-->
			<?php 
				if($this->Session->read('Auth.User.user') && $this->here!=$this->webroot.'users/login') {
				    if($this->Session->read('Auth.User.user.agent') == 1) {
						echo $this->element('agent_navigation');
					} else {
						echo $this->element('client_navigation');
					} 
				}
			?>
<!--Content-->
			<?php echo ($this->here!=$this->webroot.'users/login') ? '<div id="content" class="col-lg-10 col-sm-11">':''; ?>
				<?php echo $this->fetch('content'); ?>
			<?php echo ($this->here!=$this->webroot.'users/login') ? '</div>':''; ?>
		</div>
	</div>
<!--Footer-->
	<?php echo ($this->here!=$this->webroot.'users/login') ? $this->element('footer'):''; ?>
</body>
<span class="debug"><?php echo $this->element('sql_dump'); ?></span> 
</html>
<div id="sidebar-left" class="col-lg-2 col-sm-1">
	<div class="nav-collapse sidebar-nav collapse navbar-collapse bs-navbar-collapse">
		<ul class="nav nav-tabs nav-stacked main-menu">
<!-- home -->
			<li class="<?php echo $this->here==$this->webroot.'rankhistories/client_index'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories/client_index" class="title_link" >
					<i class="icon-home fa-bullhorn"></i>
					<?php echo __('ホーム'); ?>&nbsp;
				</a>
			</li>
<!-- notice -->
			<li class="<?php echo $this->here==$this->webroot.'notices/index'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>notices/index" class="title_link" >
					<i class="icon-bullhorn"></i>
					<?php echo __('Notice'); ?>&nbsp;
				</a>
			</li>
<!-- keyword -->
			<li class="<?php echo $this->here==$this->webroot.'rankhistories/client_keyword'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories/client_keyword" class="title_link" >
					<i class="icon-align-justify"></i>
					<?php echo __('キーワード詳細'); ?>
					<span class="label label-info" id="count_client_keyword"></span>
				</a>
			</li>
<!-- inquiry -->
			<li class="<?php echo $this->here==$this->webroot.'users/client_inquiry'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users/client_inquiry" class="title_link" >
					<i class="icon-edit"></i>
					<?php echo __('お問い合わせ'); ?>
				</a>
			</li>
			<li>&npsp;</li>
<!-- logout -->
			<li>
				<a href="<?php echo $this->webroot?>users/logout" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" ><i class="icon-lock"></i>ログアウト</a>
			</li>
		</ul>
	</div>
</div>

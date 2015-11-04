<div id="sidebar-left" class="col-lg-2 col-sm-1">
	<!--<input class="search hidden-sm" placeholder="..." type="text">-->
	<div class="nav-collapse sidebar-nav collapse navbar-collapse bs-navbar-collapse">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li class="<?php echo $this->here==$this->webroot.'rankhistories'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories" class="title_link" >
					<i class="icon-calendar"></i><?php echo __('Keyword List'); ?>&nbsp;
				</a>
			</li>
			<li class="<?php echo $this->here==$this->webroot.'users'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users" class="title_link" >
					<i class="icon-calendar"></i><?php echo __('キーワード詳細'); ?>
					<span class="label label-info" id="">20</span>	
				</a>
			</li>
			<!--<li class="<?php echo $this->here==$this->webroot.'users'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users" class="title_link" >
					<i class="icon-calendar"></i><?php echo __('提案キーワード'); ?>
					<span class="label label-important" id="">10</span>
				</a>
			</li>-->
			<li class="<?php echo $this->here==$this->webroot.'users/agent'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users/agent" class="title_link" ><i class="icon-calendar"></i><?php echo __('お問い合わせ'); ?></a>
			</li>
			<li>
				<a href="<?php echo $this->webroot?>users/logout" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" ><i class="icon-calendar"></i>ログアウト</a>
			</li>
			
			<!--<li class="<?php echo $this->here==$this->webroot.'keywords/nocontractlist'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories/nocontract" class="brand" >
					<i class="icon-calendar"></i><?php echo __('Nocontract List'); ?>&nbsp;
					<span class="label label-important" id="nocontract"></span>
				</a>
			</li>-->
			
			<!--<li class="<?php echo $this->here==$this->webroot.'keywords/kaiyakulist'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>keywords/kaiyakulist" class="brand" ><i class="icon-calendar"></i><?php echo __('Kaiyaku List'); ?></a>
			</li>-->
			
			<!--<li class="<?php echo $this->here==$this->webroot.'keywords/daily_update_ranks'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>keywords/daily_update_ranks" class="title_link" ><i class="icon-calendar"></i><?php echo __('Rank Check'); ?></a>
			</li>-->
			
		</ul>
	</div>
</div>

<!--<div class="sidebar span2">
	<div class="bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
		<li style="font-family: 'Cinzel Decorative', cursive;">
			<span style="font-size: 18px;padding-left: 15px;display: inline-block; width: 123px;"><?php echo __('System Name') ?>X</span>
		</li>
		<li><a href="<?php echo $this->webroot?>rankhistories" class="title_link <?php echo $this->here==$this->webroot.'rankhistories'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Keyword List'); ?>&nbsp;<span class="badge badge-important" id="contract"></span></a></li>
		<li><a href="<?php echo $this->webroot?>users" class="title_link <?php echo $this->here==$this->webroot.'users'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Customer List'); ?></a></li>
		<li><a href="<?php echo $this->webroot?>users/agent" class="title_link <?php echo $this->here==$this->webroot.'users/agent'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Agent List'); ?></a></li>
		<li><a href="<?php echo $this->webroot?>rankhistories/nocontract" class="brand <?php echo $this->here==$this->webroot.'keywords/nocontractlist'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Nocontract List'); ?>&nbsp;<span class="badge badge-important" id="nocontract"></span></a></li>
		<li><a href="<?php echo $this->webroot?>keywords/kaiyakulist" class="brand <?php echo $this->here==$this->webroot.'keywords/kaiyakulist'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Kaiyaku List'); ?></a></li>
		<li><a href="<?php echo $this->webroot?>keywords/daily_update_ranks" class="title_link <?php echo $this->here==$this->webroot.'keywords/daily_update_ranks'?'active':'' ?>" ><i class="icon-calendar"></i><?php echo __('Rank Check'); ?></a></li>
		<li><a href="<?php echo $this->webroot?>users/logout" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" ><i class="icon-calendar"></i>ログアウト</a></li>
	</ul>
	</div>
</div>-->

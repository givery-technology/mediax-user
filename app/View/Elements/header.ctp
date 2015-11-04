<header class="navbar">
<div class="container">
	<a id="main-menu-toggle" class="hidden-xs open"></a>
	<a class="navbar-brand col-lg-2 col-sm-1 col-xs-12" href="<?php echo $this->webroot; ?>"><span style="font-size: 18px; font-family: 'Cinzel Decorative', cursive;">SEM CHECK</span></a>
	<!-- start: Header Menu -->
	<div class="nav-no-collapse header-nav">
		<ul class="nav navbar-nav pull-right">
			<!-- start: User Dropdown -->
			<li class="dropdown">
				<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
					<div class="avatar">
						<?php 
							if($this->Layout->getLogoUser($this->Session->read('Auth.User.user.parent'))) {
								echo '<img src=/mediax.client/uploads/logo/' .$this->Layout->getLogoUser($this->Session->read('Auth.User.user.parent')) .'>';
							}
						?>
					</div>
					<div class="user">
						<span class="hello">こんにちは!</span>
						<span class="name"><?php echo $this->Session->read('Auth.User.user.company') ?>&nbsp;様</span>
					</div>
				</a>
				<ul class="dropdown-menu">
					<li class="dropdown-menu-title"></li>
					<li><a href="<?php echo $this->webroot?>notices"><i class="icon-bullhorn"></i><?php echo __('Notice') ?></a></li>
					<li><a href="<?php echo $this->webroot?>users/client_inquiry"><i class="icon-envelope"></i>お問い合わせ</a></li>
					<li><a href="<?php echo $this->webroot?>users/logout"><i class="icon-lock"></i>ログアウト</a></li>
				</ul>
			</li>
			<!-- end: User Dropdown -->
		</ul>
	</div>
</div>
</header>

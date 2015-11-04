<style>
	.error#error404 {
		margin: 2em 1em 2em 2.2em; 
		padding: 3em;
		border-radius: 0.438em;
		border: solid 0.063em #ccc;		
		border-style:solid;
		border-width:medium;
		width: auto;
	}
	
	.error#error404 p {
		width: inherit; font-size:1.5em; text-align: center;
	}
	
	a#modoru_link {
		text-align: center; width:3em; display: block; margin: 2em auto 0; 
	}
</style>
<?php $this->set("title_for_layout","エラー404：ページ存在しません"); ?>
<div class="error box" id="error404">
<!--Start Row 1-->
	<div><p>探したページはこのサイト上には見つかりませんでした。</p></div>
	<a href="<?php echo $this->webroot ?>" id="modoru_link" style="width: 30em;">MEDIAX 「トップページへ戻る」</a>
<!--End: Row 1-->
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
	    <div class="box">
			<div class="box-header">
	            <h2><?php echo __('Keyword List'); ?></h2>
		    </div>
		    <div class="box-content">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->Form->create('Rankhistory',array('class'=>'form-search')); ?>
		        <?php
		        	$current_year = date('Y'); 
		        	echo $this->Form->input('rankDate',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year, 'minYear'=>$current_year-2, 'div'=>FALSE)); 
		       	?>
		        <?php echo $this->Form->button(__('Choose'), array('class'=>'btn btn-success')); ?>
				<br /><br />    
				<div class="input-append">
					<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span3 search-query', 'type'=>'text','div'=>FALSE)); ?>
					<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
				</div>
				<?php echo $this->Form->end(); ?> 
				<div class="new-line"></div>
				<div class="common-button">
					<?php echo $this->Html->link(__('Add Keyword'), array('controller' => 'keywords' , 'action' => 'add'), array('class' => "btn btn-warning")); ?>
				</div>
				<table class="table tableX">
		            <tr>
		                <th class="tbl2"><?php echo __('KeyID'); ?></th>
		                <th class="tbl5"><?php echo __('Company'); ?></th>
		                <th class="tbl6"><?php echo __('Keyword') .'/' .__('Url'); ?></th>
		                <th class="tbl2"><?php echo __('Rank'); ?></th>
		                <th class="actions tbl2"><?php echo __('Actions'); ?></th>
		            </tr>
		            <?php foreach ($rankhistories as $rankhistory): ?>
		                <?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
		                <?php //endif ?>
		                       <tr style="background:<?php echo $params['color'] ?>">
		                    <td>
		                        <?php echo $rankhistory['Keyword']['ID']; ?>
		                    </td>
		                    <td>
		                        <?php echo $this->Html->link($user[$rankhistory['Keyword']['UserID']], array('controller' => 'users', 'action' => 'view', $rankhistory['Keyword']['UserID'])); ?>
								<?php echo ($agent[$rankhistory['Keyword']['UserID']] == 1) ? __('Agent') : ''?>
		                    </td>
		                    <td style="<?php echo !empty($rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
		                    	<?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID']),array('style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?>
<!--解約設定をしたときキーワード-->
								<br />
								<span class="kaiyaku"><?php echo (isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$rankhistory['Keyword']['rankend'] .')' : '';?></span>
								<?php echo ($rankhistory['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
								<?php 
									echo ($rankhistory['Rankhistory']['Rank'] == '') ? 
									'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$rankhistory['Keyword']['ID'])) 
									.$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
									: ''; 
								?>&nbsp;
		                    	<div class="new-line"></div>
		                    	<?php 
/*Bug URL*/
									echo $this->Html->link($rankhistory['Keyword']['Url'], $rankhistory['Keyword']['Url'], array('target'=>'_blank','style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); 
								?>
		                    </td>
		                    <td>
								<?php 
									global $list_engine;
									echo h($list_engine[$rankhistory['Keyword']['Engine']]); 
								?>&nbsp;
		                    	<?php 
									echo $rankhistory['Rankhistory']['Rank'];
								?>&nbsp;
		                        <span class="arrow_row"><?php echo $params['arrow'] ?></span>
		                    </td>
		                    <td class="actions">
		                        <div class="btn-group">
									<i class="icon-edit">
		                       			<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $rankhistory['Keyword']['ID'])); ?>
		                        	</i>
								</div>
								<div class="btn-group">
									<i class="icon-plus">
		                       			<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $rankhistory['Keyword']['ID'])); ?>
		                        	</i>
								</div>
		                            <?php if(isset($this->request->params['pass'][1]) && $this->request->params['pass'][1]==2): ?>
		                            
		                            <?php else: ?>
								<div class="btn-group">
									<i class="icon-remove">
										<?php echo $this->Html->link(__('Set Nocontract'), array('controller' => 'keywords', 'action' => 'nocontract', $rankhistory['Keyword']['ID'],($rankhistory['Keyword']['nocontract']==1?0:1))); ?>
									</i>
								</div>
		                            <?php endif ?>
		                         <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rankhistory['Rankhistory']['ID']), null, __('Are you sure you want to delete # %s?', $rankhistory['Rankhistory']['ID'])); ?> 
		                    </td>
		                </tr>
		            <?php endforeach; ?>
		        </table>
		        <?php if(isset($this->request->params['paging'])): ?>
		        <p>
		            <?php
		            echo $this->Paginator->counter(array(
		                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
		            ));
		            ?>	</p>

		        <div class="paging">
		            <?php
		            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		            echo $this->Paginator->numbers(array('separator' => ''));
		            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		            ?>
		        </div>
		        <?php endif ?>
		    </div>
		</div>
	</div>
</div>	
<?php //if(!isset($this->request->params['paging'])): ?>
<script type="text/javascript">
        /**
    $(document).ready(function() {        
        $('.compareRank').each(function(){
            var obj = $(this);
            var keyID = $(this).attr('keyID');
            var rank = $(this).attr('rank');
            var rankDate = $(this).attr('rankDate');
            $.ajax({
                url: '<?php //echo $this->webroot ?>rankhistories/compare_rank',
                data:{keyID:keyID,rank:rank,rankDate:rankDate},
                type:'POST',
                async: true,
                dataType:'json',
                success: function(data) {
                    if(data.color !='undefined' && data.color !=''){                                                       
	                    obj.css('background',data.color);
                    }else if(data.color !='undefined' && data.arrow!=''){
                        obj.parents('tr').find('td').find('.arrow_row').html(data.arrow);
                    }
                }
            })                        
        })        
    })
    */
</script>
<?php //endif ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.loadRank').click(function(){
        var keyID = $(this).attr('KeyID');
        var loading = $(this).next();
        loading.show();
        $.ajax({
            url:'<?php echo $this->webroot ?>keywords/load_rank_one',
            data:{keyID:keyID},
            type:'POST',
            success:function(data){
                //$('.section .session_flash_message_box').remove();
                //$('.section').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage">Reset RankEnd success.</div></div>');
                loading.hide();
		window.location.reload(true);
            }
        })
    })
})
</script>
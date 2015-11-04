<?php  foreach ($rankhistories as $rankhistory): ?>
<?php $params = json_decode($rankhistory['Rankhistory'][0]['params'],true) ?>
<div class="row">   
    <div class="col-lg-12">
        <div class="box">
            <div class="">
                <h2>
                    <span class="not-offer label label-info white-link"><?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID'])); ?></span>
                </h2>
                <span class="align-right">URL:<?php echo $this->Html->link($rankhistory['Keyword']['Url'], $rankhistory['Keyword']['Url'], array('target'=>'_blank','style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?></span>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
						<tr>
							<th class="" style="width:40%;">本日の順位</th>
							<th class="">   
								<?php 
									// echo $rankhistory['Rankhistory'][0]['Rank'];
									
									// Show yahoo rank
									if (strpos($rankhistory['Rankhistory'][0]['Rank'], '/') == False) {
										echo $rankhistory['Rankhistory'][0]['Rank'];
									} else {
										$rank = explode('/', $rankhistory['Rankhistory'][0]['Rank']);
										echo @$rank[1] .'/' .@$rank[1];
									}
								?>
								<span class="">
									<?php 
										echo $params['arrow'];
									?>
								</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="">対策開始日</td>
                            <td class="">
                                <?php
                                    $flag = false;
                                    foreach ($rankhistory['Duration'] as $duration):
                                        if(isset($duration['Flag']) && $duration['Flag'] == 1) {
                                            $flag = true;
                                            echo strftime('%Y年%m月%d日', strtotime($duration['StartDate']));  
                                        } 
                                    endforeach;
                                ?>
                                <?php echo ($flag==false)? '-':''; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="">初達成日</td>
                            <td class="">
                                <?php
                                    $flag = false;
                                    foreach ($rankhistory['Duration'] as $duration):
                                        if(isset($duration['Flag']) && $duration['Flag'] == 2) {
                                            $flag = true;
                                            echo strftime('%Y年%m月%d日', strtotime($duration['StartDate']));  
                                        }
                                    endforeach;
                                ?>
                                <?php echo ($flag==false)? '-':''; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="">成果対象検索エンジン</td>
                            <td class="">
                                <?php
                                    $ENGINE = Configure::read('ENGINE');
                                    echo $ENGINE[$rankhistory['Keyword']['Engine']]; 
                                ?>
                            </td>
                        </tr>
                      </tbody>
                 </table>  
            </div>
        </div>
    </div><!--/col-->
</div>
<?php endforeach; ?>
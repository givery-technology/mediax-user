<?php global $current_date;global $current_first_date;global $current_year;?>
<div class="row">
    <div class="col-lg-12">
        <div class="margin-bottom-10">
            <span class="label label-info not-offer-detail white-link">
                <?php echo $this->Html->link($keyword['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['Keyword']['ID']), array('class' => 'white-link'));?>
            </span>
            <span class="align-right">URL:<?php echo $this->Html->link($keyword['Keyword']['Url'], $keyword['Keyword']['Url'], array('target' => '_blank')); ?></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2><i class="icon-time"></i><span class="break"></span><?php  echo __('Rank History');?></h2>
            </div>
            <div class="box-content">
<!-- CSV -->
                <?php if(isset($this->request->data['Rankhistory']['RankDate_list']['month']) && isset($this->request->data['Rankhistory']['RankDate_list']['year'])): ?>
                    <div class="margin-bottom-10"><?php echo $this->Html->link(__('CSV'), array('controller' => 'rankhistories', 'action' => 'csv_by_keyword',$keyword['Keyword']['ID'],$this->request->data['Rankhistory']['RankDate_list']['year'].'-'.$this->request->data['Rankhistory']['RankDate_list']['month']), array('class' => 'btn btn-success'));?></div>
                <?php else: ?>
                    <div class="margin-bottom-10"><?php echo $this->Html->link(__('CSV'), array('controller' => 'rankhistories', 'action' => 'csv_by_keyword',$keyword['Keyword']['ID']), array('class' => 'btn btn-success'));?></div>
                <?php endif ?>
<!-- History rank data -->
                 <?php echo $this->Form->create('Rankhistory',array('class'=>'form-search','id'=>'RankhistoryViewForm_list')); ?>
                <div class="form-group">
                    <label class="control-label" for="RankhistoryRankDateMonth"><span class="label label-default"><?php echo __('History rank data'); ?></span></label>
                    <div class="controls row">
                        <div class="input-group col-sm-4">                            
                            <?php 
                                echo $this->Form->input('RankDate_list', array(                                 
                                    'div' => FALSE,
                                    'label' => FALSE,
                                    'class'=>'input-sm',
                                    'type'=>'date',
                                    'dateFormat' => 'YM',
                                    'monthNames'=>Configure::read('monthNames'),
                                    'maxYear'=> $current_year,
                                    'minYear'=>$current_year-1
                                ));
                                echo '&nbsp';
                                echo $this->Form->submit('実行',array('class'=>'btn btn-primary', 'div' => FALSE));
                            ?>                          
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end() ?>
<!--Table-->
                <table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
                    <thead>
                        <tr role="row">
                            <th style="width: auto;" colspan="1" rowspan="1" class=""><?php echo __('RankDate'); ?></th>
                            <th style="width: auto;" colspan="1" rowspan="1" class=""><?php echo __('Google/Yahoo'); ?></th>
                            <th style="width: auto;" colspan="1" rowspan="1" class=""><?php echo __('History Cache'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($data_rankhistories as $rankhistory): ?>
                    <?php $graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']))."'";  ?>
                    <tbody aria-relevant="all" aria-live="polite" role="alert">
                        <tr class="">
                            <td class="sorting_1"><?php echo date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate'])); ?>&nbsp;</td>
<!--Rank-->
                            <td  class="center"><?php echo h($rankhistory['Rankhistory']['Rank']); ?>&nbsp;</td>
<!--History Cache-->
                            <td>
                                <?php
									if ($keyword['Keyword']['Engine'] == 1) {
										$google_rank = $rankhistory['Rankhistory']['Rank'];
										$yahoo_rank = 0;
									} 
									elseif ($keyword['Keyword']['Engine'] == 2) {
										$google_rank = 0;
										$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
									}else {
										$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
										$google_rank = $ranks[0];
										$yahoo_rank = $ranks[1];
									}
									
									
									if($google_rank==0 && $yahoo_rank!=0){
								        $graph_google[] = 100;
										$graph_yahoo[] = $yahoo_rank; 
									}else if ($yahoo_rank==0 && $google_rank!=0){
								        $graph_yahoo[] = 100;
										$graph_google[] = $google_rank;                                                  
								    }else if ($google_rank == 0 && $yahoo_rank==0){
								        $graph_google[] = 100;
								        $graph_yahoo[] = 100;
									}else{
								        $graph_google[] = $google_rank;
								        $graph_yahoo[] = $yahoo_rank;                                                        
								    }   

									$cache_text = "";
									$history_limit = 90;
									$count_date = $this->Layout->CountDate($rankhistory['Rankhistory']['RankDate']);
									# Search engine google_jp & yahoo_jp. 3: Google/Yahoo 10: Google and Yahoo
									if ($keyword['Keyword']['Engine'] == 3 || $keyword['Keyword']['Engine'] == 10 || $keyword['Keyword']['Engine'] == 1 || $keyword['Keyword']['Engine'] == 2) {
										# google rank
										if ($google_rank > 0 && $google_rank <= 10 && $count_date <= $history_limit) {
											$google_cache_link = '/rankcache_new/' . $rankhistory['Rankhistory']['RankDate'] .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_google_jp", 'EUC-JP')) .'.html';
											if(isset($this->request->params['paging']['Rankhistory'])) {
												$cache_text = '<a href="../../../..' .$google_cache_link .'" target="_blank">キャッシュ</a> / ';
											}else{
												$cache_text = '<a href="../../..' .$google_cache_link .'" target="_blank">キャッシュ</a> / ';
											}
										} else if ($google_rank > 0 && $google_rank <= 10 && $count_date > $history_limit) {
											$cache_text = '保存期間対象外';
										} else {
											$cache_text = ' - / ';
										}
										
										# yahoo rank
										if ($yahoo_rank > 0 && $yahoo_rank <= 10 && $count_date <= $history_limit) {
											$yahoo_cache_link = 'http://' .$_SERVER['SERVER_NAME'] .'/rankcache_new/' .$rankhistory['Rankhistory']['RankDate'] .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_yahoo_jp", 'EUC-JP')) .'.html';
											$cache_text .= '<a href="' .$yahoo_cache_link .'" target="_blank">キャッシュ</a>';
										} else if ($yahoo_rank > 0 && $yahoo_rank <= 10 && $count_date > $history_limit) {
											$cache_text = '保存期間対象外';
										} else {
											$cache_text .= ' - ';
										}
									} else { # Search engine: not google_jp & yahoo_jp
										if (($rankhistory['Rankhistory']['Rank'] > 0 && $rankhistory['Rankhistory']['Rank'] <= 10) || ($rankhistory['Rankhistory']['Rank'] > 10 && in_array($keyid, $showcache))) {
											$cache_link = '/rankcache_new/' .$rank['RankDate'] .'/' .md5($keyword['Keyword']['Keyword'] ."_yahoo_jp") .'.html';
											if(isset($this->request->params['paging']['Rankhistory'])) {
												$cache_text = '<a href="../../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
											}else {
												$cache_text = '<a href="../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
											}
										}
									}
									echo $cache_text;
                                ?>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
                <div class="row">
                    <?php if(isset($this->request->params['paging']['Rankhistory'])): ?>
                        <div class="col-lg-12 center">
                            <span class="label label-info">
                                <?php
                                    echo $this->Paginator->counter(array(
                                        'format' => __('全{:pages}ページ・{:count}日')
                                    ));
                                ?>
                            </span>
                            <div class="dataTables_paginate paging_bootstrap">
                                <ul class="pagination">
                                    <li><?php echo $this->Paginator->prev('← ' . __('previous'), array(), null, array('class' => 'prev disabled')); ?></li>
                                    <li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
                                    <li><?php echo $this->Paginator->next(__('next') . ' →', array(), null, array('class' => 'next disabled')); ?></li>
                                </ul>
                            </div>
                            
                        </div>
                    <?php endif ?>
                </div>
                <div class="alert alert-warning">
                    ※キャッシュは最長で3ヶ月間表示します。<br />
                    ※順位はAM0時からAM5時に自動取得しており、取得する時間帯により、 表示順位とキャッシュが異なる場合がございます。
                    予めご承知おきください。<br />
                    ※順位がPCで100位圏外、モバイルで20位圏外の場合、「0」と表示されます。<br />
                    ※キャッシュは最長3ヶ月間閲覧可能です。<br />
                    ※10位以内にランクインしている場合、「順位確認」が表示され、 「順位確認」をクリックすると取得時点の順位を確認することが
                    できます。<br />
                    なお、10位圏外の場合は、表示されません。
                </div>
            </div><!--end box-content-->
        </div><!--end box-->
    </div>
</div>

<!--Graph Data-->
<?php
	$graph_google = array();
	$graph_yahoo = array();
	$graph_date = array();
	
	foreach ($rankhistories as $rankhistory):
		$graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']))."'";
		
		if ($keyword['Keyword']['Engine'] == 1) {
			$google_rank = $rankhistory['Rankhistory']['Rank'];
			$yahoo_rank = 0;
		} 
		elseif ($keyword['Keyword']['Engine'] == 2) {
			$google_rank = 0;
			$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
		}else {
			$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
			$google_rank = $ranks[0];
			$yahoo_rank = $ranks[1];
		}
		
		if($google_rank==0 && $yahoo_rank!=0){
			$graph_google[] = 100;
			$graph_yahoo[] = $yahoo_rank; 
		}else if ($yahoo_rank==0 && $google_rank!=0){
			$graph_yahoo[] = 100;
			$graph_google[] = $google_rank;                                                  
		}else if ($google_rank == 0 && $yahoo_rank==0){
			$graph_google[] = 100;
			$graph_yahoo[] = 100;
		}else{
			$graph_google[] = $google_rank;
			$graph_yahoo[] = $yahoo_rank;                                                        
		}                                        
	endforeach; 
?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2><i class="icon-eye-open"></i><span class="break"></span><?php  echo __('Graph');?></h2>
            </div>
            <div class="box-content">
<!--Graph: Date Range date-->
                <?php echo $this->Form->create('Rankhistory',array('class'=>'form-search')); ?>
                <div class="form-group">
                    <label class="control-label" for="daterange"><span class="label label-default"><?php echo __('Choose date range'); ?></span></label>
                    <div class="controls row">
                        <div class="input-group col-sm-4">
                            <span class="input-group-addon">
                                <i class="icon-calendar"></i>
                            </span>
                            <?php 
                                echo $this->Form->input('RankDate', array(
                                    'id'=>'daterange',
                                    'div' => FALSE,
                                    'label' => FALSE,
                                    'class'=>'form-control',
                                    'type'=>'text'
                                ));
                            ?>                          
                        </div>
                    </div>
                </div>
<!-- Graph -->
                <div id="graph" style="height: 400px; margin: auto"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    $('#graph').highcharts({
        title: {
            text: '<?php echo __("Rank History"); ?>',
            x: 0 //center
        },
        subtitle: {
            text: '<?php echo __("Choose upper date range to show Rank History"); ?>',
            x: 0
        },
        xAxis: {
            categories: [<?php echo implode(', ',$graph_date) ?>],
            reversed: true
        },
        yAxis: {
            title: {
                text: '<?php echo __("Rank"); ?>'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080',
            }],
            reversed: true,
            max: 100,
            min: 1
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Google',
            data: [<?php echo implode(', ',$graph_google) ?>],
        }, {
            name: 'Yahoo',
            data: [<?php echo implode(', ',$graph_yahoo) ?>],
            color: 'red'
        } ]
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        //
        $('#daterange').daterangepicker({
            format: 'YYYY/MM/DD',
             locale: {
                applyLabel: '選択',
                cancelLabel: 'キャンセル',
                fromLabel: '初日',
                toLabel: '終日',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['日', '月', '火', '水', '木', '金','土'],
                monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                firstDay: 1
            }
        });
        
        //
        $('#daterange').bind('hiddenApply',function(){
            var daterange = $('#daterange').val();
            $.ajax({
                url:'<?php echo $this->here ?>',
                data:{RankDate:daterange},
                type:'POST',
                dataType:'json',
                success:function(data){
                    var data_rankDate = [];
                    var data_google_rank = [];
                    var data_yahoo_rank = [];
                    $.each(data, function(key,val){
                        data_rankDate.push(val.Rankhistory.RankDate);
                        data_google_rank.push(parseInt(val.Rankhistory.google_rank));
                        data_yahoo_rank.push(parseInt(val.Rankhistory.yahoo_rank));
                    })
                    $('#graph').highcharts({
                        title: {
                            text: '<?php echo __("Rank History"); ?>',
                            x: 0 //center
                        },
                        subtitle: {
                            text: '<?php echo __("Choose upper date range to show Rank History"); ?>',
                            x: 0
                        },
                        xAxis: {
                            categories: data_rankDate,
                            reversed: true
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo __("Rank"); ?>'
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080',
                            }],
                            reversed: true,
                            max: 100,
                            min: 1
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                        },
                        series: [{
                            name: 'Google',
                            data: data_google_rank,
                        }, {
                            name: 'Yahoo',
                            data: data_yahoo_rank,
                            color: 'red'
                        } ]
                    });
                }
            })      
        })
    });
</script>
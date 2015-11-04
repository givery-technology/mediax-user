<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2><i class="icon-edit"></i><?php echo __('Inquiry Form'); ?></h2>
                <div class="box-icon"></div>
            </div>
            <div class="box-content">
                <?php echo $this->Session->flash(); ?>
                <div class="alert alert-warning">
                    <strong>※お問い合わせ・</strong>
                    ご質問などは下記メールフォームより受け付けております。
                </div>
                <div class="step-content">
                    <?php echo $this->Form->create('Contactus',array('url'=>array('controller'=>'Contactuses','action'=>'add'))) ?>
                    <?php echo $this->Form->input('email',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.user.email')));?>
                    <?php echo $this->Form->input('company',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.user.company')));?>
                    <?php echo $this->Form->input('name',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.user.name')));?>
                    <?php echo $this->Form->input('tel',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.user.tel')));?>
                    <?php echo $this->Form->input('ip',array('type'=>'hidden','value'=>$_SERVER['REMOTE_ADDR']));?>
                    <?php echo $this->Form->input('parent_email',array('type'=>'hidden','value'=>$this->Layout->getEmailUser($this->Session->read('Auth.User.user.parent'))));?>
                    <?php echo $this->Form->input('agent_company',array('type'=>'hidden','value'=>$this->Layout->getCompanyUser($this->Session->read('Auth.User.user.parent'))));?>
                    <div class="step-pane active" id="step1">
                        <div class="form-horizontal">
                            <fieldset class="col-sm-12">    
                                <div class="form-group">
                                  <label class="control-label" for="date"><?php echo $this->Html->tag('span', __('タイトル')); ?></label>
                                  <div class="controls row">
                                    <div class="input-group col-sm-4">
                                      <span class="input-group-addon"><i class="icon-comment"></i></span>
                                        <?php 
                                            echo $this->Form->input('subject',array(
                                                'class'=>'form-control',
                                                'type'=>'text',
                                                'div'=>false,
                                                'label'=>false
                                            ));
                                        ?>
                                    </div>
                                    <span class="help-block col-sm-8"></span>
                                  </div>
                                </div>
                                <div class="form-group">                                    
                                    <label class="control-label" for="textarea2">本文</label>
                                    <div class="controls">
                                        <?php 
                                            echo $this->Form->input('body',array(
                                                'style'=>'width: 100%; overflow: hidden; word-wrap: break-word; resize: horizontal; height: 139px;',
                                                'rows'=>6,
                                                'div'=>false,
                                                'label'=>false
                                            ));
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="step-pane" id="step2">
                        <div class="form-horizontal">
                            <fieldset class="col-sm-12">    
                                <div class="form-group">
                                    <label class="control-label">タイトル:</label>
                                    <div class="controls">
                                        <span class="input-xlarge uneditable-input review_subject"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">本文:</label>
                                    <div class="controls">
                                        <span class="input-xlarge uneditable-input review_body"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <label class="checkbox">
                                                <?php 
                                                    echo $this->Form->input('agree',array(
                                                        'type'=>'checkbox',
                                                        'div'=>false,
                                                        'label'=>false
                                                    ));
                                                ?>                                          
                                            上記の内容を確認しました。
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>  
                    </div>
                    <?php echo $this->Form->end() ?>
                </div>
                <div id="MyWizard" class="wizard">
                    <!-- <ul class="steps">
                        <li data-target="#step1" class="active"><span class="badge badge-info">1</span></li>
                        <li class="" data-target="#step2"><span class="badge">2</span></li>
                    </ul> -->
                    <div class="steps">
                        <button disabled="disabled" type="button" class="btn btn-prev"> <i class="icon-arrow-left"></i> 前</button>
                        <button disabled="disabled" type="button" class="btn btn-success btn-next" data-last="送信">次<i class="icon-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/col-->
</div><!--/row-->

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function(){
        var step_count = $('.step-pane').size()-1;
        var step_active = 0;
        var complete_id = '';
        
        $('#MyWizard button.btn-next').click(function(){
            step_active++;
            if(step_active<step_count){
                if($('#ContactusSubject').val()=='' || $('#ContactusBody').val()==''){
                    step_active--;
                    return false;
                }           
                $('.step-content .step-pane').removeClass('active');            
                $('.step-content .step-pane:eq('+step_active+')').addClass('active');
                complete_id = $('.step-content .step-pane:eq('+(step_active-1)+')').attr('id');
                $('#MyWizard .steps li[data-target="#'+complete_id+'"]').removeClass('active').addClass('complete');
            }else if(step_active==step_count){
                if($('#ContactusSubject').val()=='' || $('#ContactusBody').val()==''){
                    step_active--;
                    return false;
                }                           
                $('.step-content .step-pane').removeClass('active');            
                $('.step-content .step-pane:eq('+step_active+')').addClass('active');
                complete_id = $('.step-content .step-pane:eq('+(step_active-1)+')').attr('id');
                $('#MyWizard .steps li[data-target="#'+complete_id+'"]').removeClass('active').addClass('complete');
                
                $(this).html($(this).attr('data-last')+'<i class="icon-arrow-right"></i>');             
                $('.review_subject').html($('#ContactusSubject').val());
                $('.review_body').html($('#ContactusBody').val());
            }else if(step_active>step_count){
                step_active--;
                if($('#ContactusAgree').attr('checked')=='checked'){
                    $('#ContactusClientInquiryForm').submit();
                }　else {
                    alert('【上記の内容を確認しました】をチェックしてください');
                }
            }
            
            if(step_active>0){
                $('#MyWizard button.btn-prev').removeAttr('disabled');
            }else{
                $('#MyWizard button.btn-prev').attr('disabled','disabled');         
            }
        })

        
        //prev
        $('#MyWizard button.btn-prev').click(function(){
            step_active--;
            if(step_active>1){      
                $('.step-content .step-pane').removeClass('active');            
                $('.step-content .step-pane:eq('+step_active+')').addClass('active');
                complete_id = $('.step-content .step-pane:eq('+step_active+')').attr('id');
                $('#MyWizard .steps li[data-target="#'+complete_id+'"]').removeClass('complete').addClass('active');
            }else if(step_active==0){
                $('.step-content .step-pane').removeClass('active');            
                $('.step-content .step-pane:eq('+step_active+')').addClass('active');
                
                complete_id = $('.step-content .step-pane:eq('+step_active+')').attr('id');
                $('#MyWizard .steps li[data-target="#'+complete_id+'"]').removeClass('complete').addClass('active');            
            }else if(step_active<0){
                step_active--;
            }
            
            if(step_active<=0){
                $('#MyWizard button.btn-prev').attr('disabled','disabled');         
            }else{
                $('#MyWizard button.btn-prev').removeAttr('disabled');
            }           
        })
        
        $('#ContactusSubject, #ContactusBody').keyup(function(){
            if($('#ContactusSubject').val()=='' || $('#ContactusBody').val()==''){
                $('#MyWizard button.btn-next').attr('disabled','disabled');
            }else{
                $('#MyWizard button.btn-next').removeAttr('disabled');  
            }
        })
    })
</script>
<?php echo $this->Html->script(array('jquery-migrate-1.2.1.min', 'wizard.min'), array('inline' => FALSE)); ?>
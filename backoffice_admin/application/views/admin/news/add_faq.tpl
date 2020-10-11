{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">   
        <span id="error_msg2">{lang('qstn_req')}</span> 
        <span id="error_msg3">{lang('ans_req')}</span>    
        <span id="error_msg4">{lang('qstn_max')}</span>  
        <span id="error_msg5">{lang('ans_max')}</span>
        <span id="error_msg6">{lang('order_req')}</span>
        <span id="error_msg7">{lang('digits_only')}</span> 
        <span id="error_msg8">{lang('max_5')}</span> 
        <span id="error_msg9">{lang('digit_greater_than_0')}</span>
        <span id="validate_msg72">{lang('order_req')}</span>
        <span id="validate_msg27">{lang('checking_sort_order')}</span>
        <span id="validate_msg28">{lang('sort_order_not_available')}</span>
        <span id="validate_msg5">{lang('sort_order_available')}</span>
        <span id="confirm_msg">Do you want to delete this question?</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
          {form_open('','role="form" class="" method="post" name="faq" id="faq"')}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="control-label required" for="sort_order">{lang("sort_order")}</label>
                        <input type="text"  name="sort_order" id="sort_order"  class="form-control" autocomplete="Off">
                         <span id="checkmsg" class="error-img"></span>
                        {form_error('sort_order')}
                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('question')}</label>
                    <textarea name="question" id="question" autocomplete="Off" class="form-control textfixed"></textarea>
                    {form_error('question')}
                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('answer')}</label>
                    <textarea name="answer" id="answer" class="form-control textfixed"></textarea>
                    {form_error('answer')}
                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <button name="new_faq" type="submit" id="new_faq" class="btn btn-sm btn-primary" value="{lang('create')}">{lang('create')}</button>
            </div>
          {form_close()}
        </div>
    </div>
    
    <div class="panel panel-default table-responsive">
        <div class="panel-body">
          <legend><span class="fieldset-legend">FAQ</span></legend> 
            <div class="errorHandler alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                {lang('faq_text')}
            </div>
            {foreach from=$faq item=item} 
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#{$item.id}">
                        <div class="panel-heading"> 
                            <h4 class="panel-title">{$item.order}.{$item.question}<span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#filterPanel" id='close_icon' onclick='deleteFaq(this)' title='{lang('delete_this_question')}'><i class="icon-close"></i></span></h4>
                        </div>
                        {form_open('admin/news/delete_faq', 'class="" method="post" onsubmit="return confirmAction(\'confirm_msg\')"')}
                        <input type="hidden" name="id" value="{$item.id}">
                        {form_close()}
                        <div id="{$item.id}" class="panel-collapse panel-collapse collapse">
                            <div class="panel-body">
                                {$item.answer}
                            </div>
                        </div>
                    </a>
                </div>
            {/foreach}
        </div>
    </div>
{/block}

{block name='script'}
    <script src="{$PUBLIC_URL}/javascript/add_faq.js" type="text/javascript" ></script>
{/block}
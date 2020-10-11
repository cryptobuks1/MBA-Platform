{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;"> 
        <span id="error_msg1">{lang('catg_req')}</span>   
        <span id="error_msg2">{lang('qstn_req')}</span> 
        <span id="error_msg3">{lang('ans_req')}</span>   
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('create_faq')}</span></legend>
                {form_open('','role="form" class="" method="post" name="faq" id="faq"')}
            <div class="col-sm-12 padding_both">
                <div class="form-group">
                    <label class="required">{lang('category')}</label>
                    <select name="category"  id="category" class="form-control"  >
                        {foreach from=$category item=v}
                            <option value='{$v.id}'>{$v.category_name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('question')}</label>
                    <textarea name="question" id="question"   autocomplete="Off" class="form-control textfixed"  ></textarea>
                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('answer')}</label>
                    <textarea name="answer" id="answer" class="form-control textfixed" ></textarea>
                </div>
            </div>
            <div class="col-sm-5 padding_both_small">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary" name="new_faq" id="new_faq" value="{lang('create')}">{lang('create')}</button>
                </div>
            </div>
            {form_close()} 
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <legend><span class="fieldset-legend">{lang('faq')}</span></legend> 

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>

                    <span class="sr-only"> {lang('close')}  </span></button>
                    {lang('faq_text')} 
            </div>
            <div class="panel-group default-faq" id="accordion">
                {foreach from=$faq item=item} 
                    {* {if $item.cateory == $v.id }*}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{$item.id}">{$item.question}</a>
                            </h5>
                            <span class="pull-right btn-close clickable" id='close_icon' onclick='deleteFaq({$item.id});' title='{lang('delete_this_question')}'><i class="icon-close" ></i></span>
                        </div>
                        <div id="collapse{$item.id}" class="panel-collapse collapse">
                            <div class="panel-body">{$item.answer}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/block}
{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>

    <div class="button_back">                          
        <a href="{BASE_URL}/admin/member/invite_wallpost_config" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div> 
<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('datewise_events')}</span></legend>
        {form_open('user/calender_description','role="form" class="" method="post" name="weekly_join" id="weekly_join" target="__blank" onsubmit= "return dateValidation()"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="week_date1">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> 
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value="">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="weekdate" type="submit" value="{lang('submit')}"> {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
        <div class="panel panel-default">
            <div class="tab">
                   
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('description')}</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="i" value=1}
                        {foreach from=$calender item=v}
                        
                                <tr>
                                    <td>{$i+$start}</td>
                                    <td>{$v.start}</td> 
                                    <td>{$v.description}</td>
                                </tr>
                                {$i=$i+1}
                        {/foreach}
                        </tbody>
                    </table>
                    {$result_per_page}
     
          </div>
        </div>
                 
{/block}

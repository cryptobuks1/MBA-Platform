{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK} 
    <div id="span_js_messages" style="display: none;">
    <span id="car_bonus_req">{lang('car_bonus_field_is_required')}</span>
    <span id="greater">{lang('greater_than_zero')}</span>
    <span id="number">{lang('only_num')}</span>
    
</div>
    
      <div class="panel panel-default">
        <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('car_bonus_settings')}</span></legend>
            <div class="table-responsive">
            {form_open('','role="form" class="" name="rank_form" id="rank_form"')}
                {include file="layout/error_box.tpl"}
              
                <div class="form-group">
                    <label class="required">{lang('amount')}</label>
                    <input type="text" class="form-control" name="amount" id="amount" value="{$obj_arr['amount']}"  autocomplete="off"/>
                    {form_error('amount')}
                    
                </div>
                    
                  
                
               
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update" id="update">{lang('update')}</button>
                </div>

            {form_close()}
            </div>
        </div>
    </div>
{/block}
{block name='script'}
     {$smarty.block.parent}
         <script src="{$PUBLIC_URL}javascript/validate_rank.js"></script>
{/block}

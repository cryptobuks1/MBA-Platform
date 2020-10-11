{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK} 
    <div id="span_js_messages" style="display: none;">
    <span id="global_bonus_req">{lang('global_bonus_field_is_required')}</span>
    <span id="btwn">{lang('between_0_100')}</span>
    
    
</div>
    
      <div class="panel panel-default">
        <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('global_bonus_config')}</span></legend>
            <div class="table-responsive">
            {form_open('','role="form" class="" name="rank_form" id="rank_form"')}
                {include file="layout/error_box.tpl"}
              
                <div class="form-group">
                    <label class="required">{lang('bonus_percentage')}(%)</label>
                    <input type="text" class="form-control" name="bonus_percentage" id="bonus_percentage" value="{$obj_arr['bonus_perc']}"  autocomplete="off"/>
                    {form_error('bonus_percentage')}
                    
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

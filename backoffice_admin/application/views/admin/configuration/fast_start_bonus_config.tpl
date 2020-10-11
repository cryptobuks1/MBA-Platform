{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_fast_start_bonus.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="validate_msg13">{lang('digit_only')}</span>
        <span id="validate_msg26">{lang('field_is_required')}</span>
        <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
        <span id="lang_bonus_amount">{lang('bonus_amount')|strtolower}</span>
        <span id="lang_referral_count">{lang('referral_count1')|strtolower}</span>
        <span id="lang_days">{lang('days')|strtolower}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>

<div class="panel panel-default">
        <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        <th>{lang('rank_id')}</th> 
                        <th>{lang('rank_name')}</th>
                        <th>{lang('level_1')}(%)</th>
                        <th>{lang('level_2')}(%)</th>
                        <th>{lang('level_3')}(%)</th>
                        <th>{lang('level_4')}(%)</th>
                        <th>{lang('level_5')}(%)</th>
                        <th>{lang('level_6')}(%)</th>
                        <th>{lang('level_7')}(%)</th>
                        <th>{lang('level_8')}(%)</th>
                        <th>{lang('level_9')}(%)</th>
                        <th>{lang('level_10')}(%)</th>
                        <th>{lang('action')}</th>
                    </tr>
                    <tr>
                    
                </thead>
                
                <tbody>
                    
                    {foreach $fast_start_bonus as $v}
                    <tr>
                        
                        <input type='hidden' name='id' value = '{$v.rank_id}'>
                        <td>{$v.rank_id}</td>
                        <td>{$v.rank_name}</td>
                        <td>{$v.level1}</td>
                        <td>{$v.level2}</td>
                        <td>{$v.level3}</td>
                        <td>{$v.level4}</td>
                        <td>{$v.level5}</td> 
                        <td>{$v.level6}</td> 
                        <td>{$v.level7}</td> 
                        <td>{$v.level8}</td> 
                        <td>{$v.level9}</td> 
                        <td>{$v.level10}</td> 
                        <td>
                           {*  <input name="rank_id" id="rank_id" type="hidden" value="{$v.rank_id}" />
                            <a href="{$BASE_URL}admin/edit_fast_start_bonus?edit_id={$v.rank_id}">Edit</a>
                              *} 
                        <a href="javascript:edit_fast_start_bonus({$v.rank_id})" title="Edit"  class="btn-link btn_size has-tooltip text-info" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
                      
                       
            </table>
            </div>
            </div>
        </div> 
                {/block}
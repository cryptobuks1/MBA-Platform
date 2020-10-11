{$left_symbol = NULL}
{$right_symbol = NULL}
{$input_group_hide = "input-group-hide"}
    {$i=1}
{if $DEFAULT_SYMBOL_LEFT}
    {$input_group_hide = ""}
    {$left_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_LEFT</span>"}
{/if}
{if $DEFAULT_SYMBOL_RIGHT}
    {$input_group_hide = ""}
    {$right_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_RIGHT</span>"}
{/if}
    <legend><span class="fieldset-legend">{lang('rank_config')}</span></legend>
     <div class="rank_step_view" id="rank_step_view">

        {foreach from=$rank_details item=v}
            {assign var="rank_id" value="{$v.rank_id}"}
            <input name="rank_id{$i}" id="rank_id{$i}" type="hidden" value="{$rank_id}" />
            
            <div class="form-group">
                <label class="required">{lang('rank')}- {$i} {lang('title')}</label>
                <input type="text" class="form-control rank_name" name="rank_name{$i}" id="rank_name{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('title')|lower}" value="{$v.rank_name}">
            </div>

            <div class="referal_count_view" id="referal_count_view">
                <div class="form-group">
                    <label class="required">{lang('rank')}- {$i} {lang('referal_count')}</label>
                    <input type="text" class="form-control referal_count" name="referal_count{$i}" id="referal_count{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('referal_count')|lower}" value="{$v.referal_count}" maxlength='5'>
                </div>
            </div>
            
            <div class="downline_count_view" id="downline_count_view">
                {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}

                    <div class="form-group">
                        <label class="required">{lang('rank')}- {$i} {lang('direct_downline_member_count')}</label>
                        <input type="text" class="form-control downline_count" name="downline_count{$i}" id="downline_count{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('downline_count')|lower}" value="{$v.downline_count}" maxlength='5'>
                    </div>

                    <div class="form-group">
                        <label class="required">{lang('rank')}- {$i} {lang('team_member')} {lang('excluding_direct_downline_members')}</label>
                        <input type="text" class="form-control team_member_count" name="team_member_count{$i}" id="team_member_count{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('team_member')|lower}" value="{$v.team_member_count}" maxlength='5'>
                    </div>
                {/if}
            </div>

            <div class="pv_gpv_view" id="pv_gpv_view" style="display:none;">

                <div class="form-group">
                    <label class="required">{lang('personal_pv')}</label>
                    <input type="text" class="form-control personal_pv" name="personal_pv{$i}" id="personal_pv{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('personalpv')|lower}" value="{$v.personal_pv}" maxlength='5'>
                </div>

                <div class="form-group">
                    <label class="required">{lang('group_pv')}</label>
                    <input type="text" class="form-control group_pv" name="group_pv{$i}" id="group_pv{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('grouppv')|lower}" value="{$v.gpv}" maxlength='5'>
                </div>
            </div>

            <div class="downline_package_count_view" id="downline_package_count_view" style="display:none;">

                {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}
                    {foreach $v.package_rank as $p}
                        <div class="form-group">
                            <label class="required">{lang('minimum_count_dwn_pck')} - {$p['product_name']}</label>
                            <input type="text" class="form-control package_count" name="package_count{$i}{$p['product_id']}" id="package_count{$i}{$p['product_id']}" value="{$p['package_count']}" data-lang="{lang('you_must_enter')} {lang('member_count')}" maxlength='5'>
                        </div>
                    {/foreach}
                {/if}
            </div>

            <div class="pv_gpv_downline_rank_view" id="pv_gpv_downline_rank_view" style="display:none;">
                {assign var="downline_rank_id" value="{$v.downline_rank_id}"}
                <div class="form-group">
                    <label>{lang('downline_rank')}</label>
                    {* {print_r("<pre")}{print_r()} *}
                    <select name="downline_rank{$i}" id="downline_rank{$i}" class="form-control downline_rank">
                    <option value=""> --{lang('select')}-- </option>
                        {foreach from=$rank_details item=v key=k}
                         {if $k == $i} {break} {/if}
                         {if $i > $v.rank_id}
                            <option value="{$v.rank_id}" {if $downline_rank_id == $v.rank_id} selected {/if}>{$v.rank_name}</option>
                         {/if}
                        {/foreach}
                    </select>
                </div>

                <div class="form-group">
                    <label>{lang('downline_rank_count')}</label>
                    <input type="text" class="form-control downline_rank_count" name="downline_rank_count{$i}" id="downline_rank_count{$i}" data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('downline_rank_count')|lower}" value="{$v.downline_rank_count}" maxlength='5'>
                </div>
            </div>

            <div class="form-group">
                <label class="required">{lang('rank')}- {$i} {lang('color')}</label>
                <div class="input-group m-b colorpicker-component colorpik">
                <input class="form-control rank_color" type="text"  name="rank_color{$i}" id="rank_color{$i}"   data-lang="{lang('you_must_enter')} {lang('rank')|lower}- {$i} {lang('color')|lower}" value="{$v.rank_color}">
                <span class="input-group-addon"><i></i></span>
                </div>  
            </div>

            <hr class="new_line">
            {$i = $i+1}
        {/foreach}
    </div> 

    <div class="joined_package_view" id="joined_package_view" style="display:none;">
            {$c = 1}
            {foreach $joined_package_details as $j}
            <input name="product_id{$c}" id="product_id{$c}" type="hidden" value="{$j.product_id}" />
                <div class="form-group">
                <label class="required"> {lang('rank')} {lang('title')} {lang('for')} {$j['product_name']}</label>
                <input type="text" class="form-control rank_name_pck" value="{$j['rank_name']}" name="rank_name_pck{$c}" id="rank_name_pck{$c}" data-lang="{lang('you_must_enter')} {lang('rank')|lower} {lang('title')|lower} {lang('for')} {$j['product_name']|lower}" maxlength='5'>
            </div>

            <div class="form-group">
                <label class="required">{lang('rank')} {lang('color')} {lang('for')} {$j['product_name']}</label>
                <div class="input-group m-b colorpicker-component colorpik">
                    <input class="form-control rank_color_pck" type="text" name="rank_color_pck{$c}" id="rank_color{$c}" data-lang="{lang('you_must_enter')} {lang('rank_color')|lower} {lang('for')} {$j['product_name']|lower}" value="{$j['rank_color']}">
                    <span class="input-group-addon"><i></i></span>
                </div>  
            </div>

                <hr class="new_line">
        {$c = $c+1}
        {/foreach}
    </div> 
        
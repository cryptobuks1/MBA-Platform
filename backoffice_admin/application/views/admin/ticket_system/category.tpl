{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="err_msg1">{lang('category_is_required')}</span>
        <span id="error_msg2">{lang('exceeded_maximum_length')}</span>
        <span id="confirm_msg5">{lang('do_u_want_inactive_category')}</span>   
        <span id="confirm_msg6">{lang('do_u_want_active_category')}</span>   
    </div>
    {if isset($create_new) OR isset($edit_status)}
        <div class="panel panel-default">
            <div class="panel-body">
                <legend><span class="fieldset-legend">{if isset($edit_status)}{lang('edit_category')}{else}{lang('add_new_category')}{/if}</span></legend>
                    {form_open('','role="form" class="" method="post" name="category" id="category"')}
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="required">{lang('category_name')}<span style="color:grey; font-style: italic; "> ({lang('max_40_chars')})</span></label>
                        <input name="name" type="text" id="name" size="20" maxlength="40"  autocomplete="Off" class="form-control"  {if isset($edit_status)} value='{$edit_name}'
                        {/if}  />
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label" for="employee">{lang('assign_to')}</label>
                    <input placeholder="Type employee name here" class="form-control" type="text" id="employee" name="employee" onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event)" autocomplete="Off"  {if isset($edit_status)} value='{$edit_assignee}'
                           {/if}/>
                           <span class="help-block" for="user_name"></span>
                    </div>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group credit_debit_button">
                        {if isset($edit_status)}
                            <input type="hidden" name='edit_id' value='{$edit_id}'/>
                            <button type="submit" class="btn btn-primary" name="edit" id="edit" value="{lang('edit_category')}">{lang('edit_category')}</button>
                        {else} 
                            <button type="submit" class="btn btn-info" name="create" id="create" value="{lang('create_category')}">{lang('create_category')}</button>
                        {/if}
                    </div>
                </div>
                {form_close()}   
            </div>
        </div>
        {/if}   
            
            <div class="panel panel-default table-responsive">
             <div class="panel-body">
             <legend><span class="fieldset-legend">{lang('manage_category')}</span>
                <button class="btn m-b-xs btn-sm btn-primary btn-addon pull-right" title="{lang('add_new_category')}" onclick="addNewCategory();"><i class="fa fa-plus"></i>{lang('add_new_category')}</button>
                </legend>

                {if $category}
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('category_name')}</th>
                                <th>{lang('tickets')}</th>
                                <th>{lang('graph')}</th>
                                <th>{lang('options')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="class" value=""}
                            {assign var="i" value=0}
                            {foreach from=$category item=v}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$v.category_name}</td>
                                    <td>{$v.ticket_count}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width:{$v.ticket_per}%;"></div>
                                            <div class="progress-value">{round($v.ticket_per,2)}%</div>
                                        </div>
                                    </td>
                                    <td style="text-align:center;">

                                        {if $v.status == 1}  
                                            <button type="button" class="btn-link text-info" title="{lang('inactivate')} {$v.category_name}" onclick="deleteCategory({$v.id});">
                                                <i class="icon-ban"></i>
                                            </button>
                                        {else}
                                            <button type="button" class="btn-link  text-info" title="{lang('activate')} {$v.category_name}" onclick="activateCategory({$v.id});">
                                                <span class="icon-check"></span> 
                                            </button>
                                        {/if}    

                                        <button type="button" class="btn-link  text-info" title="{lang('edit')} {$v.category_name}" onclick="editCategory({$v.id});">
                                            <span class="fa fa-edit"></span> 
                                        </button>

                                    </td>
                                </tr>                    
                            {/foreach} 
                        </tbody>
                    </table>
                 
                    </div>
                {/if}                          
            </div>
           
            {/block}
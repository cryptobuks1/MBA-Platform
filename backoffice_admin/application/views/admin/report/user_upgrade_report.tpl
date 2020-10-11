{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
    <div class="panel panel-default">
    <div class="panel-body">
        {form_open('','role="form" class="" method="post" name="commision_form" id="commision_form"')}
      <!--  <div class="col-sm-3 padding_both">
        <div class="form-group">
            <label class="required">{lang('user_name')}</label>
            <input type="text" class="form-control user_autolist" id="user_name" name="user_name" autocomplete="Off">
        </div>
        </div>-->
         <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label  for="week_date1">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">{* {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}*}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label>{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {*{if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}*}
            </div>
        </div>
       <div class="col-sm-3 padding_both_small">
        <div class="form-group credit_debit_button">
            <button class="btn btn-primary" name="submit" type="submit" value="{lang('submit')}">
                {lang('submit')}</button>
        </div>
        </div>
        {form_close()}
    </div>
</div>
    {if $count>0}
        
      <div class="panel panel-default table-responsive">
            <div class="panel-body">
             <legend><span class="fieldset-legend">{lang('upgrade_details')}:<b>{$user_name}</b></span></legend>
                {assign var=i value="1"} 
                
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                    <th>{lang('slno')}</th>
                    <th>{lang('username')}</th>
                    <th>{lang('fullname')}</th>
                    <th>{lang('amount_paid')}</th>
                    <th>{lang('date')}</th>
                    </thead>
                     <tbody>
                         {foreach from=$details item=$v} 
                          
                     <tr>
                                <td>{$i}</td>
                                <td>{$v.username}</td>
                                <td>{$v.fullname}</td>
                                <td>{$v.amount_paid}</td>
                                <td>{$v.date}</td>
                            </tr>
                            {$i = $i+1 }
                            {/foreach}
                   
                    </tbody>
                </table>  
                </div>
            </div>
     {else}
      <div style="text-align: center">  <h3>{lang('no_data')}</h3></div>  
        {/if}
        
        
        
{/block}

{block name='script'}
     {$smarty.block.parent}
         <script src="{$PUBLIC_URL}javascript/main.js"></script>
{/block}

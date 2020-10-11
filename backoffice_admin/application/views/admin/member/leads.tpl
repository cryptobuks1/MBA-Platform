{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/leads','role="form" class="" method="post"  name="search_mem" id="search_mem"')}
            
            <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('keyword')}</label>
                <input type="text" class="form-control" placeholder="{lang('name_email_phone')}" type="text" name="keyword" id="keyword"autocomplete="Off">

            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button type="submit" class="btn btn-sm btn-primary" name="search_lead" id="search_lead" value="{lang('search_leads')}"> {lang('search')}</button>
            </div>
            </div>
            <input type="hidden" name="base_url" id="baseURL" value="{$BASE_URL}admin/">
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            {form_close()}
        </div>
    </div>

    
   

    <div class="panel panel-default ng-scope">
    <div class="panel-body">
     {if $LOG_USER_TYPE != 'employee'}
        <div class="your_lead_capture_link"><p> {lang('your_lead_capture_link')} : <a href="{SITE_URL}/lcp/{$LOG_USER_NAME}" target="_blank" style='color:#337ab7'> {SITE_URL}/lcp/{$LOG_USER_NAME}</a></p></div>
    {/if}
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th >{lang('sl_no')}</th>
                    <th >{lang('name')}</th>
                    <th >{lang('sponser_name')}</th>
                    <th >{lang('email')}</th>
                    <th >{lang('phone')}</th>
                    <th >{lang('date')}</th>
                    <th >{lang('status')}</th>
                    <th >{lang('edit')}</th>
                </tr>
            </thead>
            {if count($details)>0}
                <tbody>
                    {assign var="i" value=0}                   
                    {foreach from=$details item=v}                        
                        {if !$v.sponser_name} {$v.sponser_name='NA'}{/if}
                        {if !$v.email} {$v.email='NA'}{/if}
                        {if !$v.phone} {$v.phone='NA'}{/if}
                        {if !$v.date} {$v.date='NA'}{/if}
                        {if !$v.status} {$v.status='NA'}{/if}
                        {if $i%2 == 0}
                            {$tr_class="tr1"}  
                        {else}
                            {$tr_class="tr2"}
                        {/if}
                        {$i=$i+1}
                        <tr class="{$tr_class}">
                            <td>{$i + $page}</td>
                            <td>{$v.first_name}&nbsp;{$v.last_name}</td>
                            <td>{$v.sponser_name}</td>
                            <td>{$v.email}</td>
                            <td>{$v.phone}</td> 
                            <td>{if $v.date == 'NA'}{$v.date}{else}{date('Y/m/d', strtotime($v.date))}{/if}</td>
                            <td>{$v.status}</td>
                            <td> 
                                <a class="btn-link text-info h5" title="Edit" href ="javascript:getleadetails({$v.id},'{$BASE_URL}admin')"><i class="fa fa-edit"></i></a>
                            </td></tr>
                        {/foreach}
                </tbody>

            {else}
                <tbody>
                    <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_lead')}</h4></td></tr>
                </tbody>
            {/if}

        </table> 
        </div>
        </div>
    </div>
{$result_per_page}
    <!------modal----->
    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{lang('close')}</span></button>
                    <h3 class="modal-title" id="lineModalLabel">{lang('lead_details')}</h3>
                </div>
                <div class="modal-body panel-default table-responsive boder_none_modal" id="text_message" name="text_message">

                </div>
            </div>
        </div>
    </div>

{/block}
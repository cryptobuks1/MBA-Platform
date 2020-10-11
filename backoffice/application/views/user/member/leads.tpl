{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

   

    <div class="panel panel-default  ng-scope">
    <div class="panel-body">
     <div class="your_lead_capture_link">
        <p>
            {lang('your_lead_capture_link')}:
            {if DEMO_STATUS =='yes'}
            <a class="text-primary" href="{SITE_URL}/lcp/{$ADMIN_USER_NAME}/{$LOG_USER_NAME}" target="_blank">
                {SITE_URL}/lcp/{$ADMIN_USER_NAME}/{$LOG_USER_NAME} </a>
                {else}
                <a class="text-primary" href="{SITE_URL}/lcp/{$LOG_USER_NAME}" target="_blank">
                {SITE_URL}/lcp/{$LOG_USER_NAME}  </a>
                {/if}

        </p>
    </div>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('name')}</th>
                    <th>{lang('sponser_name')}</th>
                    <th>{lang('email')}</th>
                    <th>{lang('phone')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('status')}</th>
                    <th>{lang('edit')}</th>
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
                        {$i=$i+1}
                        {if $i%2 == 0}
                            {$tr_class="tr1"}    
                        {else}
                            {$tr_class="tr2"}
                        {/if}
                        <tr class="{$tr_class}">
                            <td>{$i + $page}</td>
                            <td>{$v.first_name}&nbsp;{$v.last_name}</td>
                            <td>{$v.sponser_name}</td>
                            <td>{$v.email}</td>
                            <td>{$v.phone}</td>
                            <td>{if $v.date == 'NA'}{$v.date}{else}{date('Y/m/d', strtotime($v.date))}{/if}</td>
                            <td>{$v.status}</td>
                            <td class="ipad_button_table">
                                <div class="field">
                                    <button class='has-tooltip btn btn_size btn-link text-info' onclick="getleadetails({$v.id}, '{$BASE_URL}user');">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <span class='tooltip green'>
                                        <p>{lang('edit')}</p>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td align="center" colspan="8"><b>{lang('no_lead')}</b></td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>
    </div>

    <!------modal----->
    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Lead details</h3>
                </div>
                <div class="modal-body panel-default table-responsive boder_none_modal" id="text_message" name="text_message">

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="base_url" id="baseURL" value="{$BASE_URL}user/">
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">

{/block}
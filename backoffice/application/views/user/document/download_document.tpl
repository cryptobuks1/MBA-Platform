{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

        {if count($file_details)!=0}
        {assign var="path" value="{$BASE_URL}admin/"}
        {assign var="i" value=0}
        {foreach from=$file_details item=v}
        {assign var="id" value="{$v.id}"}
        {assign var="date" value="{$v.uploaded_date|date_format:"%D"}"}
        {assign var="time" value="{$v.uploaded_date|date_format:"%r"}"}
        {assign var="type" value="{$v.doc_file_name|pathinfo:$smarty.const.PATHINFO_EXTENSION}"}
        {if $type == 'jpg' || $type == 'jpeg'} {assign var="type" value="png"} {/if}

        <div class="owl-item active" >
            <div class="row tm-item align-items-center">
                <figure class="col-md-2 col-lg-2"> <img src="{$SITE_URL}/uploads/images/logos/{$type}.png" alt=""> </figure>
                <div class="col-md-10 b-l">
                    <h5>{$v.file_title}</h5>
                    <p>{$v.doc_desc}</p>
                    <span><i class="fa fa-calendar"></i> {$date}</span> I <span><i class="glyphicon glyphicon-time"></i> {$time}</span><br>
                    <a href="{$SITE_URL}/uploads/images/document/{$v.doc_file_name}" title="Download" class="btn m-b-xs m-t-sm btn-info" download=""><i class="glyphicon glyphicon-download-alt"></i></a>
                </div>
            </div>
        </div>
        <hr>
        {/foreach}
        {else}
            <div align="center">
                <h4 align="center"> {lang('no_data')}</h4>
            </div>
        {/if}
    {$result_per_page}
{/block}
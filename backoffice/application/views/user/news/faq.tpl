{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>
        <span class="sr-only">Close</span></button>
    {lang("answer_to_some_faq_about")} <strong>{$COMPANY_NAME}</strong>. {lang('if_canot_find_answer')}
    </div>
    {if count($faq)!=0}
    {assign var="path" value="{$BASE_URL}admin/"}
    {assign var="i" value=0}
    {foreach from=$faq item=v}
   
        <div class="panel panel-default">
         <div class="panel-body">
            <div class="panel-heading">
             <a data-toggle="collapse" data-parent="#accordion" href="#tab{$v.id}">
                <h4 class="panel-title">{$v.order}.{$v.question} 
                <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#filterPanel"> <i class="glyphicon glyphicon-chevron-down"></i> 
                </span> </h4></a>
            </div>

            <div id="tab{$v.id}" class="panel-collapse panel-collapse collapse">
                <div class="panel-body">{$v.answer}</div>
            </div>
        </div>
        </div>
    {/foreach}
    {else}
    <h4 align="center">{lang('no_faq')}</h4>
    {/if}
{/block}
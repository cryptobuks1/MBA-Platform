
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>
        <span class="sr-only"> Close </span></button>
    {lang("answer_to_some_faq_about")} <strong>{$COMPANY_NAME}</strong>. {lang('if_canot_find_answer')}
</div>
{foreach from=$faq item=item} 
    <div class="panel panel-default">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{$item.id}">
            <div class="panel-heading">
                <h4 class="panel-title">{$item.question}<span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#collapse{$item.id}"> <i class="icon-plus"></i> </span> </h4>
            </div>
            <div id="collapse{$item.id}" class="panel-collapse panel-collapse collapse">
                <div class="panel-body">
                    <p>{$item.answer}</p>
                </div>
            </div>
        </a> 
    </div>
    <br>
{/foreach}
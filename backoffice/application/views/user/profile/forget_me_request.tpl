{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" >
           
            <div class="panel-body">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                </div> 
                {if $exist == 0}
                    {form_open('','role="form" class="smart-wizard form-inline" id="" name=""  method="post"')}
                    <div class="form-group">
                        <span> 
                            <button type="submit" class="btn btn-primary" name="request" value="{lang('forget_me_request')}" >{lang('forget_me_request')}</button>
                        </span>
                    </div>
                    {form_close()}
                {else}
                    <div class="form-group">
                        <span>{lang('already_requested')}</span>
                    </div>
                {/if}
                    {include file="common/notes.tpl" notes=lang('note_forget_me_request')}
            </div>
        </div>
    </div>
</div> 

{/block}

{block name=script}
	{$smarty.block.parent}	
    <script>
        jQuery(document).ready(function () {
            Main.init();
            ValidateUser.init();
        });
    </script>
{/block}
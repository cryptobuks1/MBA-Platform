{if $MESSAGE_DETAILS }
    {if $MESSAGE_STATUS }
        {if $MESSAGE_TYPE }
            {assign var="message_class" value="errorHandler alert alert-success"}
        {else}
            {assign var="message_class" value="errorHandler alert alert-danger"}
        {/if}
        <div class="{$message_class}">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {$MESSAGE_DETAILS}
        </div>
    {/if}
{/if}
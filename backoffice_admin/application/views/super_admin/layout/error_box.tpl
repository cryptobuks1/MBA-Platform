{if $MESSAGE_DETAILS }
    {if $MESSAGE_STATUS }
        {if $MESSAGE_TYPE }
            {assign var="message_class" value="errorHandler alert alert-success"}
            {*assign var="message_image" value="sucess.png"*}
        {else}
            {assign var="message_class" value="errorHandler alert alert-danger"}
            {*assign var="message_image" value="Error1.png"*}
        {/if}

        <div id="message_box"  class="{$message_class}">

            <div id="message_note"> 
                <table>
                    <tr>
                        <td>                            
                            {$MESSAGE_DETAILS}
                        </td>
                    </tr>
                </table>
            </div>
<a href="#" id= "close_link" class="panel-close pull-right" style="margin-top: -18px;"> <i class="fa fa-times"></i></a>
        </div>
    {/if}
{/if}


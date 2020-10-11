{if DEMO_STATUS == 'yes'}
<div class="note-demo">
    <div class="note-icon">
	    <i class="fa fa-2x fa-book"></i>
    </div>
    <div class="note-desc">
        {if isset($set_p_tag)}
            <p>{$notes}</p>
        {else}
            {$notes}
        {/if}
        
    </div>
</div>
{/if}
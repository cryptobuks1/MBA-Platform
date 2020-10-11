{extends file='admin/home/index.tpl'}

    {foreach from=$block_name item=v}
        {if !$v|in_array:$dashboard_menu}   
           {block name = $v}

          {/block}
       {/if}
    {/foreach}

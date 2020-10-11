<div>
{*!-- end: PAGE --*}
</div>
{*!-- end: MAIN CONTAINER --*}

{*!-- start: FOOTER --*}

</div>
 

{*!-- end: FOOTER --*}

{*!-- start: MAIN JAVASCRIPTS --*}
<!--[if lt IE 9]>
<script src="{$PUBLIC_URL}plugins/respond.min.js"></script>
<script src="{$PUBLIC_URL}plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{$PUBLIC_URL}plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{$PUBLIC_URL}plugins/blockUI/jquery.blockUI.js"></script>



<script src="{$PUBLIC_URL}plugins/less/less-1.5.0.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="{$PUBLIC_URL}javascript/main.js"></script>

{*!-- start: valdiation common files --*}
<script src="{$PUBLIC_URL}plugins/jquery-validation/dist/jquery.validate.min.js"></script>

{*!-- end: validation common files --*}
{*!-- end: MAIN JAVASCRIPTS --*}

{*!-- start: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}
    {foreach from = $ARR_SCRIPT item=v}
        {assign var="type" value=$v.type}
               
            {if $type == "js"}
                <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "css"}
                <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
            {elseif $type == "plugins/js"}
                <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "plugins/css"}
                <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
            {/if}
       
    {/foreach}
{*!-- end: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}

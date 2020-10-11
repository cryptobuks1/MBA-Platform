{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
	<span id="error_msg">{lang('you_must_enter_user_name')}</span>
	<span id="row_msg">{lang('rows')}</span>
	<span id="show_msg">{lang('shows')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{if $posted}
	<div id="user_account"></div>
	<div id="username_val" style="display:none;">{$user_name}</div>
{/if}

{/block}

{block name=script}
	{$smarty.block.parent}
	<script>
		$(function () {
			ValidateSearchMember.init();
		});
	</script>
{/block}
{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

{include file="admin/configuration/system_setting_common.tpl"}

<div id="span_js_messages" style="display: none;"> 
    <span id="error_language">{lang('you_must_select_a language')}</span> 
    <span id="error_main_matter1">{lang('you_must_enter_main_matter')}</span> 
    <span id="error_terms_and_condition">{lang('you_must_enter_terms_and_conditions')}</span>
    <span id="validate_mail_content">{lang('you_must_enter_mail_content')}</span>
    <span id="validate_subject">{lang('you_must_enter_subject')}</span>
</div>

<main>
    <div class="tabsy">
        <input type="radio" id="tab3" name="tab" {if $tab3} checked {/if}>
          <label class="tabButton" for="tab3">{lang('registration_email')}</label>
            <div class="tab">{include file="admin/configuration/registration_mail.tpl"  name=""}</div>

        <input type="radio" id="tab4" name="tab" {if $tab4} checked {/if}>
          <label class="tabButton" for="tab4">{lang('payout_release_mail')}</label>
            <div class="tab">{include file="admin/configuration/payout_release_mail.tpl"  name=""}</div>
    </div>
</main>

{/block}
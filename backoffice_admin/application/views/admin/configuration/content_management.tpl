{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="error_language">{lang('you_must_select_a language')}</span> 
    <span id="error_main_matter1">{lang('you_must_enter_main_matter')}</span> 
    <span id="error_terms_and_condition">{lang('you_must_enter_terms_and_conditions')}</span>
    <span id="validate_mail_content">{lang('you_must_enter_mail_content')}</span>
    <span id="validate_subject">{lang('you_must_enter_subject')}</span>
</div>

<main>
    <div class="tabsy">
        <input type="radio" id="tab1" name="tab" {if $tab1} checked {/if}>
          <label class="tabButton" for="tab1">{lang('welcome_letter')}</label>
            <div class="tab">{include file="admin/configuration/letter_config.tpl"  name=""} </div>
             
                
        {if $MODULE_STATUS['opencart_status_demo']=="no" || $MODULE_STATUS['opencart_status']=="no"}
        <input type="radio" id="tab2" name="tab" {if $tab2} checked {/if}>
          <label class="tabButton" for="tab2">{lang('terms_and_conditions')}</label>
            <div class="tab">{include file="admin/configuration/termsconditions_config.tpl"  name=""}</div>
        {/if}
       
        {* <input type="radio" id="tab3" name="tab" {if $tab3} checked {/if}>
          <label class="tabButton" for="tab3">{lang('registration_email')}</label>
            <div class="tab">{include file="admin/configuration/registration_mail.tpl"  name=""}</div>

        <input type="radio" id="tab4" name="tab" {if $tab4} checked {/if}>
          <label class="tabButton" for="tab4">{lang('payout_release_mail')}</label>
            <div class="tab">{include file="admin/configuration/payout_release_mail.tpl"  name=""}</div> *}
        {if DEMO_STATUS == 'yes' && $MODULE_STATUS['opencart_status'] == 'yes' && $is_preset_demo}
        {else}
        {if $MODULE_STATUS['replicated_site_status'] == 'yes'}  
        <input type="radio" id="tab5" name="tab" {if $tab5} checked {/if}>
          <label class="tabButton" for="tab5">{lang('replica_site')}</label>
            <div class="tab">{include file="admin/configuration/replica_configuration.tpl"  name=""}</div>
        {/if}  
        {/if}
        <input type="radio" id="tab3" name="tab" {if $tab3} checked {/if}>
          <label class="tabButton" for="tab3">{lang('upgradeTerms')}</label>
            <div class="tab">{include file="admin/configuration/upgarde_terms.tpl"  name=""}</div>
            
            <input type="radio" id="tab6" name="tab" {if $tab6} checked {/if}>
          <label class="tabButton" for="tab6">{lang('upgrade_text')}</label>
            <div class="tab">{include file="admin/configuration/upgrade_text.tpl"  name=""}</div>
    </div>
</main>

{/block}
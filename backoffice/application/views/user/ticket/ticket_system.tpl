{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('subject_is_required')}</span>
        <span id="error_msg2">{lang('priority_is_required')}</span>
        <span id="error_msg3">{lang('category_is_required')}</span>
        <span id="error_msg4">{lang('message_is_required')}</span>      
    </div>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    <main>
        <div class="tabsy">
            <input type="hidden" name="active_tab" id="active_tab"  value="" >
            <input type="radio" id="tab1" name="tab" {$tab1}>
            <label class="tabButton" for="tab1">{lang('inbox')}</label>
            <div class="tab">
                <div class="content">
                    <div class="tab-pane{$tab1}">
                    {include file="user/ticket/ticket_inbox.tpl"  name=""}
                    </div>
                </div>
            </div>
            <input type="radio" id="tab2" name="tab" {$tab2}>
            <label class="tabButton" for="tab2">{lang('create_ticket')}</label>
            <div class="tab">
                <div class="content">
                    {include file="user/ticket/create_ticket.tpl"  name=""}
                </div>
            </div>
            <input type="radio" id="tab3" name="tab" {$tab3}>
            <label class="tabButton" for="tab3">{lang('view_ticket')}</label>

            <div class="tab">
                <div class="content">
                    {include file="user/ticket/view_ticket.tpl"  name=""}
                </div>
            </div>
            <input type="radio" id="tab4" name="tab" {$tab4}>
            <label class="tabButton" for="tab4">{lang('resolved_tickets')}</label>
            <div class="tab">
                <div class="content">
                    {include file="user/ticket/resolved_ticket.tpl"  name=""}
                </div>
            </div>
            <input type="radio" id="tab5" name="tab" {$tab5}>
            <label class="tabButton" for="tab5">{lang('search_tickets')}</label>
            <div class="tab">
                <div class="content">
                    {include file="user/ticket/search_ticket.tpl"  name=""}
                </div>
            </div>
            <input type="radio" id="tab6" name="tab" {$tab6}>
            <label class="tabButton" for="tab6">{lang('faqs')}</label>
            <div class="tab">
                <div class="content"> 
                    {include file="user/ticket/ticket_faq.tpl"  name=""}
                </div>
            </div>
        </div>
    </main>
{/block}

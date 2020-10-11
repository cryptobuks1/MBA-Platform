<div class="wrapper_index">
<div class="region  panel setting_margin  setting_margin_top">
    <div id="block-block-12" class="block block-block contextual-links-region clearfix">
        <div class=" features-quick-access">
            <div class="hbox text-center b-light text-sm bg-white">
                <a href="{$BASE_URL}admin/general_setting" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/general_setting'} setting-selected {/if}">
                    <i class="fa fa-desktop block m-b-xs fa-2x"></i>
                    <span>{lang('general')}</span>
                </a>
                <a href="{$BASE_URL}admin/compensation_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/compensation_settings'} setting-selected {/if}">
                    <i class="fa fa-calculator block m-b-xs fa-2x"></i>
                    <span>{lang('compensation')}</span>
                </a>
                {if $MLM_PLAN == 'Board' || $MLM_PLAN == 'Matrix'}
                    <a href="{$BASE_URL}admin/plan_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/plan_settings'} setting-selected {/if}">
                        <i class="fa fa-cogs block m-b-xs fa-2x"></i>
                        <span>
                            {if $MLM_PLAN == 'Matrix'}
                                {lang('matrix')}
                            {elseif $MLM_PLAN == 'Board' && $MODULE_STATUS['table_status'] == 'yes'}
                                {lang('table')}
                            {else}
                                {lang('board')}
                            {/if}
                        </span>
                    </a>
                {/if}
                {if $MLM_PLAN == 'Stair_Step'}
                <a href="{$BASE_URL}admin/stairstep_configuration" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/stairstep_configuration'} setting-selected {/if}">
                    <i class="fa fa-sticky-note block m-b-xs fa-2x"></i>
                    <span>{lang('stairstep')}</span>
                </a>
                {/if}
                {if $MLM_PLAN == 'Donation'}
                <a href="{$BASE_URL}admin/donation_configuration" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/donation_configuration'} setting-selected {/if}">
                    <i class="fa fa-gift block m-b-xs fa-2x"></i>
                    <span>{lang('donation')}</span>
                </a>
                {/if}
                {if $MODULE_STATUS['rank_status'] == 'yes'}
                <a href="{$BASE_URL}admin/rank_configuration" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/rank_configuration'} setting-selected {/if}">
                    <i class="fa fa-trophy block m-b-xs fa-2x"></i>
                    <span>{lang('rank')}</span>
                </a>
                {/if}
                <a href="{$BASE_URL}admin/payout_setting" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/payout_setting'} setting-selected {/if}">
                    <i class="fa fa-history block m-b-xs fa-2x"></i>
                    <span>{lang('payout')}</span>
                </a>
                <a href="{$BASE_URL}admin/payment_view" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/payment_view'} setting-selected {/if}">
                    <i class="fa fa-credit-card block m-b-xs fa-2x"></i>
                    <span>{lang('payment')}</span>
                </a>
                {if $MODULE_STATUS['pin_status'] == 'yes'}
                <a href="{$BASE_URL}admin/pin_config" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/pin_config'} setting-selected {/if}">
                    <i class="fa fa-tags block m-b-xs fa-2x"></i>
                    <span>{lang('epin')}</span>
                </a>
                {/if}
                {if $MODULE_STATUS['signup_config'] == 'yes'}
                <a href="{$BASE_URL}admin/signup_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/signup_settings'} setting-selected {/if}">
                    <i class="fa fa-user-plus block m-b-xs fa-2x"></i>
                    <span>{lang('signup')}</span>
                </a>
                {/if}
                <a href="{$BASE_URL}admin/mail_content" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/mail_content'} setting-selected {/if}">
                    <i class="fa fa-envelope block m-b-xs fa-2x"></i>
                    <span>{lang('mail')}</span>
                </a>
                {if $MODULE_STATUS['sms_status'] == 'yes'}
                <a href="{$BASE_URL}admin/sms_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/sms_settings'} setting-selected {/if}">
                    <i class="fa fa-comments block m-b-xs fa-2x"></i>
                    <span>{lang('sms')}</span>
                </a>
                {/if}
                {if $MODULE_STATUS['multy_currency_status'] == 'yes'}
                <a href="{$BASE_URL}admin/currency/currency_management" class="col padder-v text-muted {if $CURRENT_URL == 'currency/currency_management'} setting-selected {/if}">
                    <i class="fa fa-money block m-b-xs fa-2x"></i>
                    <span>{lang('currency')}</span>
                </a>
                {/if}
                {* {if $MODULE_STATUS['roi_status'] == 'yes'}
                <a href="{$BASE_URL}admin/holidays_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/holidays_settings'} setting-selected {/if}">
                    <i class="fa fa-calendar block m-b-xs fa-2x"></i>
                    <span>{lang('holiday')}</span>
                </a>
                {/if} *}
                <a href="{$BASE_URL}admin/tooltip_settings" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/tooltip_settings'} setting-selected {/if}">
                    <i class="fa fa-arrows block m-b-xs fa-2x"></i>
                    <span>{lang('tooltip')}</span>
                </a>
                {* <a href="{$BASE_URL}admin/inactivity_logout" class="col padder-v text-muted {if $CURRENT_URL == 'configuration/inactivity_logout'} setting-selected {/if}">
                    <i class="fa fa-sign-out block m-b-xs fa-2x"></i>
                    <span>{lang('logout')}</span>
                </a> *}
            </div>
        </div>
    </div>
</div>
</div>

<style>
a {
    word-break: normal;
}
</style>

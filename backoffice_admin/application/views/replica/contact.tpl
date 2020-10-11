{extends file=$BASE_TEMPLATE}
{block name= style}
<style>
    .upper{
        text-transform: uppercase;
    }
    .no-display {
        display: none;
    }
</style>
{/block}
{block name=$CONTENT_BLOCK}
        {include file="replica/error_box.tpl" title="" name=""}
<section id="contact" class="contact_section bd-bottom padding" data-scroll-id="contact" tabindex="-1" style="outline: none;">
    <div id="span_js_messages" style="display: none;">
        <span id="validate_contact_msg11"><font>{lang('you_must_enter_a_name')}</font></span>
        <span id="validate_contact_msg12"><font>{lang('only_characters_are_allowed')}</font></span>
        <span id="validate_contact_msg21"><font>{lang('you_must_enter_an_email')}</font></span>
        <span id="validate_contact_msg22"><font>{lang('you_must_enter_a_valid_email')}</font></span>
        <span id="validate_contact_msg31"><font>{lang('you_must_enter_a_phone_number')}</font></span>
        <span id="validate_contact_msg32"><font>{lang('only_digits')}</font></span>
        <span id="validate_contact_msg41"><font>{lang('you_must_enter_an_address')}</font></span>
        <span id="validate_msg1"><font>{lang('maxlength_n_allowed')}</font></span>
        <span id="validate_msg2"><font>{lang('minlength_n_allowed')}</font></span>
        <span id="validate_msg3"><font>{lang('maxlength_characte_allowedr_n')}</font></span>
    </div>

    <div class="container">
        <div class="contact_wrapper">
            <div class="col-md-6 sm-padding">
                <div class="section_heading mb-30">
                    <h2 class="upper">{lang('contact')} <span>{lang('Us')}</span></h2>
                    <p>{$site_info['company_name']}</p>
                    <p>{if isset($content['address'])}{$content['address']}
                        {else}{$site_info['company_address']}
                        {/if}</p>
                </div>
            </div>
            <div class="col-md-6 sm-padding">
                <div class="contact_box">
                    <div class="section_heading mb-30">
                        <h2 class="upper">{lang('get_in')} <span>{lang('touch')}</h2>

                    </div><!-- /.section_heading -->
                    <div class="contact_form">
                        {form_open('replica/contact',' role="form" id="contact_form" method="post"
                        name="contact_form" class="form-horizontal footer_form"')}
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" name="name" id="name" class="form-control" placeholder="{lang('Name')}"
                                    value="{if isset($contact_post_array['name'])}{$contact_post_array['name']}{/if}" />
                                <span class="help-block"></span>{if isset($contact_error['name'])}<span class='val-error'>{$contact_error['name']}
                                </span>{/if}
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="email" class="form-control" placeholder="{lang('Email')}"
                                    value="{if isset($contact_post_array['email'])}{$contact_post_array['email']}{/if}">
                                <span class="help-block"></span>{if isset($contact_error['email'])}<span class='val-error'>{$contact_error['email']}
                                </span>{/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="{lang('Phone_Number')}"
                                    value="{if isset($contact_post_array['phone'])}{$contact_post_array['phone']}{/if}">
                                <span class="help-block"></span>{if isset($contact_error['phone'])}<span class='val-error'>{$contact_error['phone']}
                                </span>{/if}
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="address" id="address" class="form-control" placeholder="{lang('address')}"
                                    value="{if isset($contact_post_array['address'])}{$contact_post_array['address']}{/if}">
                                <span class="help-block"></span>{if isset($contact_error['address'])}<span class='val-error'>{$contact_error['address']}
                                </span>{/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea rows="4" name="describe" id="describe" class="form-control" placeholder="{lang('Describe-yourself')}"> {if isset($contact_post_array['describe'])}{$contact_post_array['describe']}{/if}</textarea>
                                {if isset($contact_error['describe'])}<span class='val-error'>{$contact_error['describe']}
                                </span>{/if}
                            </div>
                        </div>

                        <button class="zarra_btn" type="submit" value="submit" name="submit" id="submit">
                            {lang('Submit')}</button>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{/block}

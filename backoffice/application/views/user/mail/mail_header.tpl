       
        <div class="col w-md bg-light dk b-r bg-auto">
            <div class="wrapper b-b bg">
                <button class="btn btn-sm btn-default pull-right visible-sm visible-xs" ui-toggle-class="show" target="#email-menu"><i class="fa fa-bars"></i></button>
                <a href="{$BASE_URL}user/mail/compose_mail" class="btn btn-sm btn-primary w-xs font-bold">{lang('compose')}</a>
            </div>
            <div class="wrapper hidden-sm hidden-xs" id="email-menu">
                <ul class="nav nav-pills nav-stacked nav-sm">
                    <li {if $CURRENT_URL=="mail/mail_management"}class="active"{/if}>
                        <a href="{$BASE_URL}user/mail/mail_management"><i class="fa fa-inbox"></i> {lang('inbox')}
                            <span class="label label-primary pull-right">{if $unread_mail>0}{$unread_mail}{else}0{/if}</span>
                        </a>
                    </li>
                    <li style="display: none;" {if $CURRENT_URL=="mail/mail_sent"}class="active"{/if}>
                        <a href="{$BASE_URL}user/mail/mail_sent"><i class="fa fa-envelope-o"></i> {lang('sent')}</a>
                    </li>
                </ul>
            </div>
        </div>
              
              
<?php
/* Smarty version 3.1.30, created on 2020-08-05 05:53:36
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/theme_setting.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29bcc09ac162_43428193',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0531057079c153ad2729bb578623717c5fd06780' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/theme_setting.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f29bcc09ac162_43428193 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- theme settings -->
<div class="settings panel panel-default">
    <button class="btn btn-default no-shadow pos-abt" ui-toggle-class="active" target=".settings">
        <i class="fa fa-spin fa-gear"></i>
    </button>
    <div class="panel-heading">
        Settings
    </div>
    <div class="panel-body">
        <div class="m-b-sm">
            <label class="i-switch bg-info pull-right">
                <input type="checkbox" name="headerFixed" class="ng-pristine ng-untouched ng-valid ng-empty"
                    aria-invalid="false">
                <i></i>
            </label>
            Fixed header
        </div>
        <div class="m-b-sm">
            <label class="i-switch bg-info pull-right">
                <input type="checkbox" name="asideFixed" class="ng-pristine ng-untouched ng-valid ng-empty"
                    aria-invalid="false">
                <i></i>
            </label>
            Fixed aside
        </div>
        <div class="m-b-sm">
            <label class="i-switch bg-info pull-right">
                <input type="checkbox" name="asideFolded" class="ng-pristine ng-untouched ng-valid ng-empty"
                    aria-invalid="false">
                <i></i>
            </label>
            Folded aside
        </div>
        <div class="m-b-sm">
            <label class="i-switch bg-info pull-right">
                <input type="checkbox" name="asideDock" class="ng-pristine ng-untouched ng-valid ng-empty"
                    aria-invalid="false">
                <i></i>
            </label>
            Dock aside
        </div>
        <div>
            <label class="i-switch bg-info pull-right">
                <input type="checkbox" name="container" class="ng-pristine ng-untouched ng-valid ng-empty"
                    aria-invalid="false">
                <i></i>
            </label>
            Boxed layout
        </div>
    </div>
    <div class="wrapper b-t b-light bg-light lter r-b">
        <div class="row row-sm">
            <div class="col-xs-6">
                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="1" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-black header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-black"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="13" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-dark header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="2" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                    aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-white header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-black"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="3" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-primary header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="4" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-info header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-black"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="5" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-success header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>

                <label class="i-checks block" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="6" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-danger header"></b>
                        <b class="bg-white header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>
            </div>
            <div class="col-xs-6">
                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="7" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-black header"></b>
                        <b class="bg-black header"></b>
                        <b class="bg-white"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="14" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-dark header"></b>
                        <b class="bg-dark header"></b>
                        <b class="bg-light"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="8" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-info dker header"></b>
                        <b class="bg-info dker header"></b>
                        <b class="bg-light dker"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="9" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-primary header"></b>
                        <b class="bg-primary header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="10" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-info dker header"></b>
                        <b class="bg-info dk header"></b>
                        <b class="bg-black"></b>
                    </span>
                </label>

                <label class="i-checks block m-b-sm" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="11" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-success header"></b>
                        <b class="bg-success header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>

                <label class="i-checks block" role="button" tabindex="0">
                    <input type="radio" name="themeID" value="12" class="ng-pristine ng-untouched ng-valid ng-not-empty"
                        aria-invalid="false">
                    <span class="block bg-light clearfix pos-rlt">
                        <span class="active pos-abt w-full h-full bg-black-opacity text-center">
                            <i class="glyphicon glyphicon-ok text-white m-t-xs"></i>
                        </span>
                        <b class="bg-danger dker header"></b>
                        <b class="bg-danger dker header"></b>
                        <b class="bg-dark"></b>
                    </span>
                </label>
            </div>
        </div>
    </div>
</div>
<!-- / theme settings --><?php }
}

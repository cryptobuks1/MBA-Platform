{include file="super_admin/layout/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('project_details')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="main-login col-sm-4 col-sm-offset-4">
                    <h3>{lang('project_details')}</h3>
                    <form role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" action="" method="post">
                        <div class="form-group">
                            <label class="col-sm-4" for="user_name">{lang('user_name')}</label>
                            <label class="col-sm-8" for="user_name">{$demo_details["user_name"]}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4" for="full_name">{lang('full_name')}</label>
                            <label class="col-sm-8" for="full_name">{$demo_details["full_name"]}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4" for="email">{lang('email')}</label>
                            <label class="col-sm-8" for="email">{$demo_details["email"]}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4" for="phone">{lang('phone')}</label>
                            <label class="col-sm-8" for="phone">{$demo_details["phone"]}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4" for="mlm_plan">{lang('plan')}</label>
                            <label class="col-sm-8" for="mlm_plan">{$demo_details["mlm_plan"]}</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}
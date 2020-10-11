<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('user_account')}
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
            <div class="row">
                <div class="col-sm-12">                   
                    <div class="panel-body">
                        {form_open_multipart('','role="form" class="" name="searchform" id="searchform" action="" method="post"')}
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                        <div class="col-sm-3 padding_both">
                            <div class="form-group">
                                <label class="required" for="user_name"> {lang('user_name')}</label>
                                <input name="user_name" class="form-control" id="user_name" type="text" onkeyup="ajax_showOptions(this, 'getCountriesByLetter', event)" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3 padding_both_small">
                            <div class="form-group">
                                <button class="btn btn-bricky" type="submit" id="user_details" value="user_details" name="user_details">
                                    {lang('search')}
                                </button>
                            </div>
                        </div>

                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<style>
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
        .main-content > .container {
            height: -webkit-fill-available;
        }
        .spacer-xs {

            height: -webkit-fill-available !important;
        }
    }
</style>
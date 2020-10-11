{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="validate_pan1">{lang('please_upload_pan')}</span>
        <span id="validate_pan2">{lang('please_upload_pan')}</span>
        <span id="validate_aadhar1">{lang('please_upload_aadhar')}</span>
        <span id="validate_aadhar2">{lang('please_upload_aadhar')}</span>
        <span id="validate_aadhar_number">{lang('aadhar_number_require')}</span>
        <span id="validate_max_aadhar">{lang('max_aadhar')}</span>
        <span id="validate_min_aadhar">{lang('min_aadhar')}</span>
        <span id="validate_aadhar2">{lang('please_upload_aadhar')}</span>
        <span id="validate_pan_number">{lang('pan_number_require')}</span>
        <span id="validate_max_pan">{lang('max_pan')}</span>
        <span id="validate_min_pan">{lang('min_pan')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('','role="form" class=""  name="kyc_form" id="kyc_form"')}
            <div class="col-sm-4 padding_both">
                <label>{lang('select_category')}</label>
                <div class="form-group">
                    <select class="form-control" name="category" id="category">
                        {foreach from=$kyc_catg item=v}
                            <option value="{$v.id}">{$v.category}</option>
                        {/foreach}
                    </select>
                    {form_error('category')}
                </div>
            </div>
            <input type="hidden" name="house_counter" id="house_counter" value="0">
            <div class="col-sm-4 padding_both_small">
                <div class="form-group">
                    <label class="control-label required">{lang('select_file')}</label>
                    <div data-provides="fileupload" class="bg_file_upload fileupload fileupload-new">
                        <span id='house_div'>
                            <input type="file" id="id_proof" name="id_proof[]" tabindex="2" required>
                        </span>     
                    </div>
                    <span class="help-block m-b-none">{lang('Allowed_types_are_pdf_jpg_png')}</span>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small mark_paid">
                <button type="button" class="fileupload-exists btn btn-sm btn-primary"  onclick="addIdproof()" title="{lang('add_more_files')}"><i class="fa fa-plus-square"></i></button>
                <button class="btn btn-sm btn-primary" type="submit" name="upload_kyc" id="upload_kyc"  value="{lang('upload')}" > {lang('Upload')} </button>
            </div>
            {form_close()}
        </div>
    </div>
 
    <div class="panel panel-default ng-scope">
 
      <div class="panel-body">
       <legend><span class="fieldset-legend">{lang('uploaded_docs')}</span></legend>
      <div class="table-responsive">
        {if count($identity_proof)}
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <th>{lang('sl_no')}</th>
                        <th>{lang('doc_name')}</th>
                        <th>{lang('status')}</th>
                        <th>{lang('files')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$identity_proof item=v}
                        {form_open_multipart('','role="form"')}
                        <tr>
                            <td>{counter}</td> 
                            <td>{$v['category']}</td>
                            <td><span class="label label-{$v['font_class']}"> {lang($v['status'])}</span>                                      
                                {if $v['status'] eq 'rejected'}
                                    <br>{lang('reason')} : {$v['reason']}
                                {/if}
                            </td>
                            <td>
                                {foreach from=$v['file_name'] item=f}
                                    {if $f|pathinfo:$smarty.const.PATHINFO_EXTENSION == 'pdf'}
                                        <a href="{$SITE_URL}/uploads/images/document/kyc/{$f}" class="btn btn-primary" data-placement="top" data-original-title="" title="{lang('download')}">
                                            <i class="fa fa-download" data-toggle="tooltip" title="Download"></i></a>
                                        {else}
                                        <a class="btn btn-primary thumbs" href="javascript:mym('{$SITE_URL}/uploads/images/document/kyc/{$f}')"> <img id="borderimg1" width="30" height="20" src="{$SITE_URL}/uploads/images/document/kyc/{$f}" scrolling="no"></a>
                                        {/if}
                                    {/foreach}
                            </td>
                            <td>
                                <button class="btn-link text-danger" type="submit" id="delete" name='delete' title="{lang('delete')}" value="{$v['id']}"> <i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        {form_close()}
                    {/foreach}
                </tbody>
            </table>
             </div>
             </div>
        {else}
            <h4 class="text-center">{lang('no_details')}</h4>
        {/if}  
    </div>
    <div class="modal fade" id="EnSureModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="text-align:center;width:100%">
                    <img id="im" src="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
{/block}
{block name='script'}
    <script>
        jQuery(document).ready(function () {
        });
        var house_counter = 1;
        function addIdproof() {
            if (house_counter < 2) {
                var span = document.createElement('span');
                span.className = '';
                span.innerHTML = '<input type="file" id="id_proof' + house_counter + '" name="id_proof[]" tabindex="' + house_counter + '">';
                document.getElementById('house_div').appendChild(span);
                document.getElementById("house_counter").value = house_counter;
                house_counter = house_counter + 1;
            } else {
                alert("You can't upload more than 2 ");
            }
        }
        function mym(image) {
            document.getElementById("im").src = image;
            $("#EnSureModal").modal();
        }
    </script>
{/block}
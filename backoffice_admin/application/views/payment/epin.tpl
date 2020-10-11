<style type="text/css">
      .panel-body .col-sm-3 {
    min-height: 0px;
    }
</style>
<div class="col-sm-12">
<div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="epin_table">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('epin')} </th> 
                <th>{lang('epin_amount')}  </th>
                <th class="center">{lang('remain_epin_amount')}  </th> 
                <th>{lang('req_epin_amount')} </th> 
            </tr>
        </thead> 
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    <input class="form-control epin_input" type="text" name="epin[]"  autocompleautote="Off"/>                                                    
                </td>
                <td> 
                    <input class="form-control" type="text" name="pin_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="remaining_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="balance_amount[]" readonly/>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<form class="row">
<div class="col-sm-5 row_padding_lfet">
    <div class="form-group">
        <label>{lang('total_amount')}</label>
        <input type="text" name="epin_total_amount" id="epin_total_amount" class="form-control" readonly="">
    </div>
</div>
<div class="col-sm-5 padding_both_small">
    <div class="form-group mark_paid">
        <button type="button" id="check_epin" class="btn btn-sm btn-primary">{lang('validate_epin')}</button>
        <button type="submit" name="epin_submit" id="epin_submit" value="epin_submit" class="btn btn-sm btn-primary"  disabled="">{lang('submit')}</button>
    </div>
</div>
</form>

<div id="epin_row" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td></td>
                <td>
                    <input class="form-control epin_input" type="text" name="epin[]" autocompleautote="Off"/>                                                    
                </td>
                <td> 
                    <input class="form-control" type="text" name="pin_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="remaining_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="balance_amount[]" readonly/>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="{$PUBLIC_URL}javascript/payment/epin.js"></script>
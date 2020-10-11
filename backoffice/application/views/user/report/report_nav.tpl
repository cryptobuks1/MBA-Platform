<div class="button_back">
    {if $excel_url}<a href="{$excel_url}"><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>{/if} {if $csv_url}
    <a href="{$csv_url}"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>{/if}
    <a onClick="print_report(); return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i>{lang('Print')}</button>
    </a></div>
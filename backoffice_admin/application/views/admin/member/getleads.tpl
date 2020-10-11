{form_open('admin/edit_Lead_Capture', 'role="form" class="" method="post" name="" id=""')}
    <table  border='0'  align='center' margin-left='0px' margin-right='0px' class='table table-responsive' >
        <tr>
            <td>{lang('name')}</td>
            <td>:<td>
            <td>{$details['first_name']} {$details['last_name']}</td>
        </tr>
        <tr>
            <td>{lang('sponser_name')}</td>
            <td>:<td>
            <td>{$details['sponser_name']}</td>
        </tr>
        <tr>
            <td>{lang('email')}</td>
            <td>:<td>
            <td>{$details['email_id']}</td>
        </tr>
        <tr>
            <td>{lang('skype')}</td>
            <td>:<td>
            <td>{$details['skype_id']}</td>
        </tr>
        <tr>
            <td>{lang('phone')}</td>
            <td>:<td>
            <td>{$details['mobile_no']}</td>
        </tr>
        <tr>
            <td>{lang('country')}</td>
            <td>:<td>
            <td>{$details['country']}</td>
        </tr>
        <tr>
            <td>{lang('date')}</td>
            <td>:<td>
            <td>{$details['date']}</td>
        </tr>
        <tr>
            <td>{lang('description')}</td>
            <td>:<td>
            <td>{$details['description']}</td>
        </tr>
        {$i = 1}
        {foreach from=$comment_admin item=v}
            <tr>
                <td>{lang('comment')} {$i}</td>
                <td>:<td>
                <td>{$v['description']}</td>   
            </tr>
            {$i = $i + 1}
        {/foreach}
        <tr>
            <td>Add comment</td>
            <td>:<td>
            <td>
                <textarea id='admin_comment' name='admin_comment' class='form-control textfixed'></textarea>
            </td>
        </tr>
        <tr>
            <td>{lang('status')}</td>
            <td>:<td>
            <td>
                <select name='status' id='status' class='form-control' >
                    <option value='Ongoing'{$following_status}>Ongoing</option>
                    <option value='Accepted' {$reg_status}>Accepted</option>
                    <option value='Rejected' {$dec_status}>Rejected</option>
                </select>  
            </td>
        </tr>
    </table>
    <br/>
    <input type='hidden' name='lead_id' id='lead_id' value='{$details['id']}'>
        <div class='modal-footer'>
            <div class='text-center modal_form_bottum'>
                <button value='Update' id='edit_lead' name='edit_lead' class='btn m-b-xs w-xs btn-primary' type='submit'>{lang('update')}</button>
                <button class='btn m-b-xs w-xs btn-success'  data-dismiss='modal'  role='button'>Close</button>
            </div>
        </div>
{form_close()}
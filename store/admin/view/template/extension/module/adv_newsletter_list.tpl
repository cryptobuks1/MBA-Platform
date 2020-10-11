<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
        <td class="text-left" style="width: 400px">Email</td>
        <td class="text-center">Subscribed date</td>
        <td class="text-center">Status</td>
        <td class="text-center">Action</td>
    </tr>
    <tbody>
        <tr>
            <td></td>
            <td><input type="text" name="filter_email" value="<?php echo $filter_email?>"></td>
            <td colspan="3"></td>
        </tr>
        <?php foreach($emails as $email) { ?>
        <tr>
            <td class="text-center"><?php if (in_array($email['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $email['id']; ?>" checked="checked" />
                <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $email['id']; ?>" />
                <?php } ?></td>
            <td><?php echo $email['email']?></td>
            <td class="text-center"><?php echo $email['created_date']?></td>
            <td class="text-right"><?php echo $email['status']?></td>
            <td class="text-center">
                <select name="status[<?php echo $email['id']?>][]" id="">
                    <option value="0" <?php echo ($email['status_ori'] == '0' ? 'selected="selected"' : '')?>>Disabled</option>
                    <option value="1" <?php echo ($email['status_ori'] == '1' ? 'selected="selected"' : '')?>>Enabled</option>
                    <option value="2" <?php echo ($email['status_ori'] == '2' ? 'selected="selected"' : '')?>>Blacklist</option>
                    <option value="3" <?php echo ($email['status_ori'] == '3' ? 'selected="selected"' : '')?>>Un-subscribed</option>
                    <option value="4" <?php echo ($email['status_ori'] == '4' ? 'selected="selected"' : '')?>>Non-verified</option>
                </select>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    </thead>
</table>
<div class="row">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
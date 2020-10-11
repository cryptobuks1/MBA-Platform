{if {$DEMO_STATUS} == 'yes'}
<pre class="alert alert-info">{lang('payeer_only_in_live')}</pre>
{else}
<div class="form form-horizontal">
    <div class="form-group">
        <div class="col-sm-3">
            <button type="submit" name="payeer_submit" id="payeer_submit" value="payeer_submit" class="btn btn-sm btn-primary">{lang('submit')}</button>
        </div>
    </div>
</div>
{/if}
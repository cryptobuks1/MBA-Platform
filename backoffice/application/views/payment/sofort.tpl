{if {$DEMO_STATUS} == 'yes'}
<pre class="alert alert-info">{lang('sofort_only_in_live')}</pre>
{else}
<div class="form form-horizontal">
    <div class="form-group">
        <div class="col-sm-3">
            <button type="submit" name="sofort_submit" id="sofort_submit" value="sofort_submit" class="btn btn-sm btn-primary">{lang('submit')}</button>
        </div>
    </div>
</div>
{/if}
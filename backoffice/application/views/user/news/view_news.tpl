{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    {if count($news_details)!=0}
    {assign var="path" value="{$BASE_URL}admin/"}
    {assign var="i" value=0}
    {foreach from=$news_details item=v}
    {assign var="news_id" value="{$v.news_id}"}
    {assign var="date" value="{$v.news_date|date_format:"%D"}"}
    {assign var="time" value="{$v.news_date|date_format:"%r"}"}

    <!---NEW NEWS--->
        <div class="owl-item active">
            <div class="row tm-item align-items-center">
                <figure class="col-md-2 col-lg-2 "> <img src="{$SITE_URL}/uploads/images/logos/news.png" alt=""> </figure>
                <div class="col-md-10 b-l">
                    <h5>{$v.news_title}</h5>
                    <p>{$v.news_desc}</p>
                    <span><i class="glyphicon glyphicon-time"></i> {$date}</span> I
                    <span><i class="fa fa-calendar"></i> {$time}</span>
                </div>
            </div>
        </div>
        <hr>
    <!--END NEW NEWS--->
    {/foreach}
    {else}
    <h4 align="center">{lang('no_news_found')}</h4>
    {/if}
{$result_per_page}
{/block}
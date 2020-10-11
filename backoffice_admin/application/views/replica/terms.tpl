{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<section class="content_section bd-bottom">
  <div class="container">
    <div class="col-md-12">
      <div class="content_wrapper_1">
        <h2>{lang('terms_and_conditions')}</h2>
        {if isset($content['terms'])}
        <p>{$content['terms']}</p>
        {else}
        <p>All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM
          software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other
          compensation plans. This is developed by a leading MLM software development company Infinite Open Source
          Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by
          the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating
          Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more.</p>
        {/if}
      </div>
    </div>
  </div>
</section>
{/block}
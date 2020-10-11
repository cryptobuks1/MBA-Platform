{extends file=$BASE_TEMPLATE}
{block name= style}

<style>
  .upper {
    text-transform: uppercase;
  }
</style>
{/block}
{block name=$CONTENT_BLOCK}

<section class="content_section bd-bottom">
    <div class="container">
        <div class="content_wrapper">
            <div class="col-md-6">
                    <div class="content_info">
                        <h2 class="upper">{lang('About')} {lang('Us')}</h2>
                        <p>{if isset($content['about_us'])}<p>{$content['about_us']}</p>
                        {else}<p>The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix,
                          Unilevel and many other compensation plans. This is developed by a leading MLM software development company
                          Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the
                          business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,
                          Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design</p>
                        {/if}</p>
                         
                        <a href="#" class="zaara_btn_2 hidden">Learn More</a>
                    </div>
            </div>
            <div class="col-md-6 hidden-xs hidden-sm wow fadeInRight" data-wow-delay="200ms" data-wow-duration="800ms" style="visibility: visible; animation-duration: 800ms; animation-delay: 200ms; animation-name: fadeInRight;">
                <img src="{$PUBLIC_URL}replica/theme/img/macbook.png" alt="image">
            </div>
        </div>
    </div>
</section>
{/block}

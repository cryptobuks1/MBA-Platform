{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
		
		 <section class="content_section bd-bottom">
		    <div class="container">
		        <div class="content_wrapper">
		            <div class="col-md-6">
                        <div class="content_info">
                            <h2>{$subtitle}</h2>
                            <p>{$description}</p>
                             
                            <a href="#" class="zaara_btn_2 hidden">Learn More</a>
                        </div>
		            </div>
		            <div class="col-md-6 hidden-xs hidden-sm wow fadeInRight" data-wow-delay="200ms" data-wow-duration="800ms" style="visibility: visible; animation-duration: 800ms; animation-delay: 200ms; animation-name: fadeInRight;">
		                <img src="{$PUBLIC_URL}/replica/theme/img/macbook.png" alt="image">
		            </div>
		        </div>
		    </div>
		</section>
{/block}

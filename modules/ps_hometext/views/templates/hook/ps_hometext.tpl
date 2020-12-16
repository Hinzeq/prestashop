<div id="ps_hometext_block_home" class="block">
    <h2>Polecamy w tym tygodniu</h2>
    
    <div class="container">
        <div class="row">
            {foreach from=$prod item=product}
                {if $product.id_category_default == 11} <!-- 11 -> numer kategorii, ustawiłem ją jako główną dla wybranych produktów -->
                    <div class="col-md-6">
                        {block name='product_thumbnail'}
                            {if $product.cover}
                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                <img
                                src="{$product.cover.bySize.home_default.url}"
                                alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                                data-full-size-image-url="{$product.cover.large.url}"
                                />
                            </a>
                            {else}
                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                <img src="{$urls.no_picture_image.bySize.home_default.url}" />
                            </a>
                            {/if}
                        {/block}
                    </div>
                {/if}
            {/foreach}
        </div>
    </div>
</div>

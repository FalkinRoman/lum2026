{{-- Figma shop social: @lum_shop_sl / WhatsApp — desk 192:1177, tab 192:1273, mob 192:1368 --}}
<div
    class="flex items-start gap-[16px] whitespace-nowrap text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-espresso"
    data-lum-stay-intro-item
    data-lum-stay-intro-order="3"
>
    @include('lum.partials.link-footer-nav', [
        'label' => __('lum.shop.social_instagram'),
        'href' => __('lum.shop.social_instagram_url'),
        'variant' => 'line',
        'underlineTone' => 'espresso',
        'classes' => 'text-lum-espresso',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
    <span class="text-lum-espresso/16">/</span>
    @include('lum.partials.link-footer-nav', [
        'label' => __('lum.shop.social_whatsapp'),
        'href' => __('lum.shop.social_whatsapp_url'),
        'variant' => 'line',
        'underlineTone' => 'espresso',
        'classes' => 'text-lum-espresso',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
</div>

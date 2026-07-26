@if (\App\Support\Exely::enabled())
<style>
    .lum-exely-booking {
        width: 100%;
        max-width: 100%;
        position: relative;
    }

    .lum-exely-booking *,
    .lum-exely-booking *::before,
    .lum-exely-booking *::after {
        box-sizing: border-box;
    }

    .lum-exely-booking__mount {
        width: 100%;
        max-width: 100%;
        min-height: 420px;
    }

    @media (min-width: 1024px) {
        .lum-exely-booking__mount {
            min-height: 560px;
        }
    }

    /* Не трогать #tl-booking-cart: fixed + width:100% + left:16px = отступ только слева */
    .lum-exely-booking__mount > div:not(#tl-booking-cart) {
        width: 100% !important;
        max-width: 100% !important;
    }

    .lum-exely-booking__mount > div:not(#tl-booking-cart) iframe {
        display: block;
        width: 100% !important;
        max-width: 100% !important;
    }

    #tl-booking-cart {
        z-index: 40 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        max-width: 100vw !important;
        box-sizing: border-box !important;
    }

    #tl-booking-cart iframe {
        display: block;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
    }
</style>

<div class="lum-exely-booking">
    <div id="be-booking-form" class="lum-exely-booking__mount"></div>
</div>
@endif

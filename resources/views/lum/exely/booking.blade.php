@if (\App\Support\Exely::enabled())
<style>
    .lum-exely-booking {
        width: 100%;
        max-width: 100%;
        position: relative;
        overflow-x: clip;
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
        overflow-x: clip;
    }

    @media (min-width: 1024px) {
        .lum-exely-booking__mount {
            min-height: 560px;
        }
    }

    .lum-exely-booking__mount > div {
        width: 100% !important;
        max-width: 100% !important;
    }

    .lum-exely-booking__mount iframe {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        left: 0 !important;
        margin: 0 !important;
    }

    #tl-booking-cart {
        z-index: 40 !important;
    }
</style>

<div class="lum-exely-booking">
    <div id="be-booking-form" class="lum-exely-booking__mount"></div>
</div>
@endif

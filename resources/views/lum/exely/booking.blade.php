@if (\App\Support\Exely::enabled())
<style>
    .lum-exely-booking {
        width: 100%;
        position: relative;
    }

    .lum-exely-booking *,
    .lum-exely-booking *::before,
    .lum-exely-booking *::after {
        box-sizing: border-box;
    }

    .lum-exely-booking__shell {
        position: relative;
        width: 100%;
        min-height: 520px;
    }

    @media (min-width: 1024px) {
        .lum-exely-booking__shell {
            min-height: 640px;
        }
    }

    .lum-exely-booking__mount {
        width: 100%;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    .lum-exely-booking__shell.is-ready .lum-exely-booking__mount {
        opacity: 1;
        pointer-events: auto;
    }

    .lum-exely-booking__shell.is-ready .lum-exely-booking-skeleton {
        display: none;
    }

    .lum-exely-booking__mount > div,
    .lum-exely-booking__mount iframe {
        width: 100% !important;
        max-width: 100% !important;
    }

    #tl-booking-cart {
        z-index: 40 !important;
    }

    /* Skeleton — под стиль Lum, пока грузится iframe */
    .lum-exely-booking-skeleton {
        position: absolute;
        inset: 0;
        display: grid;
        gap: 16px;
        align-content: start;
    }

    @media (min-width: 1024px) {
        .lum-exely-booking-skeleton {
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
        }
    }

    .lum-exely-booking-skeleton__main,
    .lum-exely-booking-skeleton__side {
        border: 1px solid rgba(46, 39, 32, 0.12);
        background: #fffddf;
        padding: 24px 20px;
    }

    @media (min-width: 431px) {
        .lum-exely-booking-skeleton__main,
        .lum-exely-booking-skeleton__side {
            padding: 32px 28px;
        }
    }

    .lum-exely-booking-skeleton__side {
        background: #2e2720;
        color: #fffddf;
    }

    .lum-exely-booking-skeleton__eyebrow {
        margin: 0 0 8px;
        font-family: Jost, sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: rgba(46, 39, 32, 0.4);
    }

    .lum-exely-booking-skeleton__title {
        margin: 0 0 20px;
        font-family: "Vollkorn", serif;
        font-size: 28px;
        line-height: 32px;
        font-weight: 400;
        color: #2e2720;
    }

    @media (min-width: 431px) {
        .lum-exely-booking-skeleton__title {
            font-size: 36px;
            line-height: 40px;
        }
    }

    .lum-exely-booking-skeleton__side .lum-exely-booking-skeleton__title {
        color: #fffddf;
    }

    .lum-exely-booking-skeleton__row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        min-height: 56px;
        padding: 12px 16px;
        margin-bottom: 10px;
        border: 1px solid rgba(46, 39, 32, 0.12);
        border-radius: 12px;
        background: rgba(255, 251, 178, 0.35);
        font-family: Jost, sans-serif;
        font-size: 14px;
        color: #2e2720;
    }

    .lum-exely-booking-skeleton__row span {
        color: rgba(46, 39, 32, 0.4);
        font-size: 12px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    .lum-exely-booking-skeleton__meta {
        display: grid;
        gap: 14px;
        margin: 0;
    }

    .lum-exely-booking-skeleton__meta div {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 253, 223, 0.16);
        font-family: Jost, sans-serif;
        font-size: 14px;
    }

    .lum-exely-booking-skeleton__meta dt {
        margin: 0;
        color: rgba(255, 253, 223, 0.56);
    }

    .lum-exely-booking-skeleton__meta dd {
        margin: 0;
        text-align: right;
    }

    .lum-exely-booking-skeleton__btn {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        min-height: 48px;
        padding: 0 24px;
        border-radius: 999px;
        background: #41606b;
        color: #fffddf;
        font-family: Jost, sans-serif;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 2.84px;
        text-transform: uppercase;
        text-decoration: none;
    }

    .lum-exely-booking-skeleton__note {
        margin: 14px 0 0;
        font-family: Jost, sans-serif;
        font-size: 12px;
        line-height: 18px;
        color: rgba(255, 253, 223, 0.48);
    }
</style>

<div class="lum-exely-booking">
    <div class="lum-exely-booking__shell" data-lum-exely-booking-shell>
        <div class="lum-exely-booking-skeleton" data-lum-exely-booking-skeleton aria-hidden="true">
            <div class="lum-exely-booking-skeleton__main">
                <p class="lum-exely-booking-skeleton__eyebrow">{{ __('lum.booking.eyebrow') }}</p>
                <h2 class="lum-exely-booking-skeleton__title">{{ __('lum.booking.rooms_title') }}</h2>
                @foreach (__('lum.booking.demo_rooms') as $room)
                    <div class="lum-exely-booking-skeleton__row">
                        <div>
                            <span>{{ $room['meta'] }}</span>
                            <div>{{ $room['title'] }}</div>
                        </div>
                        <strong>{{ $room['price'] }}</strong>
                    </div>
                @endforeach
            </div>
            <aside class="lum-exely-booking-skeleton__side">
                <h3 class="lum-exely-booking-skeleton__title">{{ __('lum.booking.summary_title') }}</h3>
                <dl class="lum-exely-booking-skeleton__meta">
                    <div>
                        <dt>{{ __('lum.booking.check_in') }}</dt>
                        <dd>{{ __('lum.booking.demo_check_in') }}</dd>
                    </div>
                    <div>
                        <dt>{{ __('lum.booking.check_out') }}</dt>
                        <dd>{{ __('lum.booking.demo_check_out') }}</dd>
                    </div>
                    <div>
                        <dt>{{ __('lum.booking.guests') }}</dt>
                        <dd>{{ __('lum.booking.guests_placeholder') }}</dd>
                    </div>
                    <div>
                        <dt>{{ __('lum.booking.total') }}</dt>
                        <dd>{{ __('lum.booking.demo_total') }}</dd>
                    </div>
                </dl>
                <span class="lum-exely-booking-skeleton__btn">{{ __('lum.booking.confirm_cta') }}</span>
                <p class="lum-exely-booking-skeleton__note">{{ __('lum.booking.demo_note') }}</p>
            </aside>
        </div>

        <div id="be-booking-form" class="lum-exely-booking__mount" data-lum-exely-booking-mount></div>
    </div>
</div>

<script>
(function () {
    var shells = document.querySelectorAll('[data-lum-exely-booking-shell]:not([data-lum-exely-watched])');

    shells.forEach(function (shell) {
        shell.setAttribute('data-lum-exely-watched', '1');

        var mount = shell.querySelector('[data-lum-exely-booking-mount]');
        if (! mount) {
            shell.classList.add('is-ready');
            return;
        }

        var done = false;
        var finish = function () {
            if (done) return;
            done = true;
            shell.classList.add('is-ready');
            document.dispatchEvent(new CustomEvent('lum:layout-change'));
        };

        var watchIframe = function (iframe) {
            if (! iframe || iframe.dataset.lumExelyBound) return;
            iframe.dataset.lumExelyBound = '1';

            var settle = function () {
                var tries = 0;
                var last = 0;
                var tick = function () {
                    var h = parseInt(iframe.style.height || iframe.getAttribute('height') || '0', 10);
                    var visible = getComputedStyle(iframe).display !== 'none';
                    if (visible && h > 80 && h === last) {
                        finish();
                        return;
                    }
                    last = h;
                    tries += 1;
                    if (tries > 50) {
                        finish();
                        return;
                    }
                    window.setTimeout(tick, 60);
                };
                tick();
            };

            iframe.addEventListener('load', settle, { once: true });
            window.setTimeout(settle, 0);
        };

        var pickIframe = function () {
            var iframes = mount.querySelectorAll('iframe');
            for (var i = 0; i < iframes.length; i++) {
                if (getComputedStyle(iframes[i]).display !== 'none') {
                    return iframes[i];
                }
            }
            return iframes[0] || null;
        };

        var obs = new MutationObserver(function () {
            var iframe = pickIframe();
            if (iframe) watchIframe(iframe);
        });

        obs.observe(mount, { childList: true, subtree: true, attributes: true, attributeFilter: ['style', 'height'] });

        var existing = pickIframe();
        if (existing) watchIframe(existing);

        window.setTimeout(finish, 8000);
    });
})();
</script>
@endif

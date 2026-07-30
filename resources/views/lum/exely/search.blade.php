@php
    $variant = $variant ?? 'main'; // main | sticky | hero | inline
    $hotelId = $hotelId ?? null;
    $containerId = \App\Support\Exely::searchContainerId($hotelId);
    $hotelLabel = \App\Support\Exely::hotelLabel($hotelId);
    $isSticky = $variant === 'sticky';
    $isHero = $variant === 'hero';
    $isInline = $variant === 'inline';
    $isMulti = blank($hotelId);
    $showHead = $showHead ?? (! $isInline && ! $isSticky && ! $isHero);
@endphp

@if (\App\Support\Exely::enabled())
<style>
    .lum-exely-search {
        box-sizing: border-box;
        width: 100%;
        background: transparent;
        position: relative;
        z-index: 20;
    }

    .lum-exely-search *,
    .lum-exely-search *::before,
    .lum-exely-search *::after {
        box-sizing: border-box;
    }

    .lum-exely-search--sticky {
        background: rgba(255, 253, 223, 0.96);
        box-shadow: 0 4px 24px rgba(46, 39, 32, 0.08);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(46, 39, 32, 0.08);
    }

    .lum-exely-search--hero {
        margin-top: -12px;
    }

    @media (min-width: 431px) {
        .lum-exely-search--hero {
            margin-top: -20px;
        }
    }

    .lum-exely-search__frame {
        width: 100%;
        margin: 0 auto;
        padding: 0;
    }

    .lum-exely-search--sticky .lum-exely-search__frame,
    .lum-exely-search--hero .lum-exely-search__frame,
    .lum-exely-search--main .lum-exely-search__frame {
        max-width: 1470px;
        padding: 16px 20px 18px;
    }

    @media (min-width: 431px) {
        .lum-exely-search--sticky .lum-exely-search__frame,
        .lum-exely-search--hero .lum-exely-search__frame,
        .lum-exely-search--main .lum-exely-search__frame {
            padding: 18px 20px 20px;
        }
    }

    @media (min-width: 1024px) {
        .lum-exely-search--sticky .lum-exely-search__frame,
        .lum-exely-search--hero .lum-exely-search__frame,
        .lum-exely-search--main .lum-exely-search__frame {
            padding: 20px 0 22px;
        }
    }

    .lum-exely-search--inline .lum-exely-search__frame {
        max-width: none;
        padding: 0;
    }

    .lum-exely-search__head {
        margin-bottom: 12px;
    }

    .lum-exely-search__eyebrow {
        margin: 0 0 4px;
        font-family: Jost, sans-serif;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: rgba(46, 39, 32, 0.4);
    }

    .lum-exely-search__title {
        margin: 0;
        font-family: "Vollkorn", serif;
        font-size: 28px;
        line-height: 32px;
        font-weight: 500;
        color: #2e2720;
    }

    @media (min-width: 431px) {
        .lum-exely-search__title {
            font-size: 34px;
            line-height: 38px;
        }
    }

    /*
     * Skeleton живёт СНАРУЖИ #be-search-form — Exely чистит только mount.
     * Пока iframe не load — виден скелетон 1:1 с финальным виджетом.
     */
    .lum-exely-search__shell {
        position: relative;
        width: 100%;
        min-height: 390px;
    }

    @media (min-width: 431px) {
        .lum-exely-search__shell {
            min-height: 198px;
        }
    }

    @media (min-width: 1024px) {
        .lum-exely-search__shell {
            min-height: 100px;
        }
    }

    .lum-exely-search__mount {
        width: 100%;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .lum-exely-search__shell.is-ready .lum-exely-search__mount {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    /* Пока Exely тянет CSS в parent — не показываем сырой iframe */
    .lum-exely-search__shell:not(.is-ready) .lum-exely-search__mount * {
        visibility: hidden !important;
    }

    .lum-exely-search__shell.is-ready .lum-exely-skeleton {
        display: none;
    }

    .lum-exely-search__mount > div,
    .lum-exely-search__mount iframe {
        width: 100% !important;
        max-width: 100% !important;
    }

    .lum-exely-skeleton {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        font-family: Jost, sans-serif;
        color: #2e2720;
    }

    .lum-exely-skeleton__brand {
        flex: 0 0 auto;
        padding-right: 8px;
        min-width: 120px;
    }

    .lum-exely-skeleton__brand strong {
        display: block;
        font-family: "Vollkorn", serif;
        font-size: 22px;
        font-weight: 500;
        line-height: 1.1;
        color: #2e2720;
    }

    .lum-exely-skeleton__brand span {
        display: block;
        margin-top: 2px;
        font-size: 10px;
        line-height: 1.2;
        color: rgba(46, 39, 32, 0.35);
    }

    .lum-exely-skeleton__fields {
        display: flex;
        flex: 1 1 auto;
        flex-wrap: wrap;
        align-items: stretch;
        gap: 10px;
        min-width: 0;
    }

    .lum-exely-skeleton__field {
        display: flex;
        flex: 1 1 140px;
        flex-direction: column;
        justify-content: center;
        gap: 2px;
        min-height: 52px;
        padding: 8px 14px;
        border: 1px solid rgba(46, 39, 32, 0.18);
        border-radius: 12px;
        background: #fffddf;
    }

    .lum-exely-skeleton__field em {
        font-style: normal;
        font-size: 10px;
        line-height: 1;
        color: rgba(46, 39, 32, 0.45);
    }

    .lum-exely-skeleton__field b {
        font-size: 14px;
        font-weight: 400;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lum-exely-skeleton__promo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 52px;
        padding: 0 16px;
        border-radius: 12px;
        background: #ebe8c8;
        font-size: 13px;
        white-space: nowrap;
        color: #2e2720;
    }

    .lum-exely-skeleton__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 52px;
        padding: 0 28px;
        border-radius: 999px;
        background: #2e2720;
        color: #fffddf;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 2.2px;
        text-transform: uppercase;
        text-decoration: none;
        white-space: nowrap;
    }

    @media (max-width: 430px) {
        .lum-exely-skeleton {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .lum-exely-skeleton__brand {
            min-width: 0;
        }

        .lum-exely-skeleton__fields {
            flex-direction: column;
        }

        .lum-exely-skeleton__field {
            flex: 1 1 auto;
        }
    }
</style>

<div @class([
    'lum-exely-search',
    'lum-exely-search--main' => $variant === 'main',
    'lum-exely-search--sticky' => $isSticky,
    'lum-exely-search--hero' => $isHero,
    'lum-exely-search--inline' => $isInline,
])>
    <div class="lum-exely-search__frame">
        @if ($showHead)
            <div class="lum-exely-search__head">
                <p class="lum-exely-search__eyebrow">{{ __('lum.booking.search_label') }}</p>
                <h2 class="lum-exely-search__title">{{ __('lum.booking.search_title') }}</h2>
            </div>
        @endif

        <div class="lum-exely-search__shell" data-lum-exely-shell>
            {{-- Скелетон = визуальный клон Exely, пока iframe грузится --}}
            <div class="lum-exely-skeleton" data-lum-exely-skeleton aria-hidden="true">
                <div class="lum-exely-skeleton__brand">
                    <strong>{{ __('lum.booking.search_title') }}</strong>
                    <span>hotel management software</span>
                </div>
                <div class="lum-exely-skeleton__fields">
                    @if ($isMulti)
                        <div class="lum-exely-skeleton__field">
                            <em>{{ __('lum.booking.hotel') }}</em>
                            <b>{{ __('lum.booking.hotel_placeholder') }}</b>
                        </div>
                    @elseif ($hotelLabel)
                        <div class="lum-exely-skeleton__field">
                            <em>{{ __('lum.booking.hotel') }}</em>
                            <b>{{ $hotelLabel }}</b>
                        </div>
                    @endif
                    <div class="lum-exely-skeleton__field">
                        <em>{{ __('lum.booking.check_in') }}</em>
                        <b>{{ __('lum.booking.date_placeholder') }}</b>
                    </div>
                    <div class="lum-exely-skeleton__field">
                        <em>{{ __('lum.booking.check_out') }}</em>
                        <b>{{ __('lum.booking.date_placeholder') }}</b>
                    </div>
                    <div class="lum-exely-skeleton__field">
                        <em>{{ __('lum.booking.guests') }}</em>
                        <b>{{ __('lum.booking.guests_placeholder') }}</b>
                    </div>
                    <span class="lum-exely-skeleton__promo">{{ __('lum.booking.promo') }}</span>
                    <span class="lum-exely-skeleton__btn">{{ __('lum.booking.search_cta') }}</span>
                </div>
            </div>

            <div id="{{ $containerId }}" class="lum-exely-search__mount" data-lum-exely-mount></div>
        </div>
    </div>
</div>

<script>
(function () {
    var shells = document.querySelectorAll('[data-lum-exely-shell]:not([data-lum-exely-watched])');

    shells.forEach(function (shell) {
        shell.setAttribute('data-lum-exely-watched', '1');

        var mount = shell.querySelector('[data-lum-exely-mount]');
        if (! mount) {
            shell.classList.add('is-ready');
            return;
        }

        var done = false;
        var finish = function () {
            if (done) return;
            done = true;
            shell.classList.add('is-ready');
            if (window.ScrollTrigger && typeof window.ScrollTrigger.refresh === 'function') {
                window.ScrollTrigger.refresh();
            }
            document.dispatchEvent(new CustomEvent('lum:layout-change'));
        };

        var watchIframe = function (iframe) {
            if (! iframe) return;
            if (iframe.dataset.lumExelyBound) return;
            iframe.dataset.lumExelyBound = '1';

            var settle = function () {
                // Exely ресайзит iframe + подгружает CSS в parent — ждём стабильную высоту + паузу
                var tries = 0;
                var last = 0;
                var stable = 0;
                var tick = function () {
                    var h = parseInt(iframe.style.height || iframe.getAttribute('height') || '0', 10);
                    if (h > 40 && h === last) {
                        stable += 1;
                    } else {
                        stable = 0;
                    }
                    last = h;
                    tries += 1;
                    if (stable >= 4 || tries > 60) {
                        window.setTimeout(finish, 350);
                        return;
                    }
                    window.setTimeout(tick, 50);
                };
                tick();
            };

            iframe.addEventListener('load', settle, { once: true });
            // уже мог загрузиться к моменту observe
            if (iframe.contentWindow) {
                window.setTimeout(settle, 0);
            }
        };

        var obs = new MutationObserver(function () {
            var iframe = mount.querySelector('iframe');
            if (iframe) {
                watchIframe(iframe);
            }
        });

        obs.observe(mount, { childList: true, subtree: true });

        var existing = mount.querySelector('iframe');
        if (existing) {
            watchIframe(existing);
        }

        // fail-safe — не держим скелетон вечно
        window.setTimeout(finish, 6000);
    });
})();
</script>
@endif

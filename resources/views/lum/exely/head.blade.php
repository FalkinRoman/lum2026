@if (\App\Support\Exely::enabled())
@php
    $locale = \App\Support\Exely::locale();
    $integration = \App\Support\Exely::integrationId();
@endphp
<link rel="preconnect" href="https://lk-ibe.hopenapi.com" crossorigin>
<link rel="preconnect" href="https://ibe.hopenapi.com" crossorigin>
<link rel="dns-prefetch" href="https://lk-ibe.hopenapi.com">
<link rel="dns-prefetch" href="https://ibe.hopenapi.com">
{{-- Exely Booking Engine loader — сразу в head, без defer --}}
<script type="text/javascript">
    !function(e,n){
        var t="bookingengine",o="integration",i=e[t]=e[t]||{},a=i[o]=i[o]||{},r="__cq",c="__loader",d="getElementsByTagName";
        if(n=n||[],a[r]=a[r]?a[r].concat(n):n,!a[c]){a[c]=!0;var l=e.document,g=l[d]("head")[0]||l[d]("body")[0];
        !function n(i){if(0!==i.length){var a=l.createElement("script");a.type="text/javascript",a.async=!0,a.src="https://"+i[0]+"/integration/loader.js",
        a.onerror=a.onload=function(n,i){return function(){e[t]&&e[t][o]&&e[t][o].loaded||(g.removeChild(n),i())}}(a,(function(){n(i.slice(1,i.length))})),g.appendChild(a)}}(
        ["lk-ibe.hopenapi.com", "ibe.hopenapi.com", "ibe.behopenapi.com"])}
    }(window, [
            ["setContext", @json($integration), @json($locale)],
            ["embed", "booking-form", {
                    container: "be-booking-form"
            }],
            ["embed", "search-form", {
                    container: "be-search-form"
            }],
            ["setContext", @json($integration.'.514444'), @json($locale)],
            ["embed", "search-form", {
                    container: "be-search-form-514444"
            }],
            ["setContext", @json($integration.'.502887'), @json($locale)],
            ["embed", "search-form", {
                    container: "be-search-form-502887"
            }]
        ]);
</script>
@endif

@php
    $backHref = $backHref
        ?? ((url()->previous() !== url()->current()) ? url()->previous() : route('home'));
    $paragraphs = collect(preg_split("/\n\s*\n/", trim((string) ($page['body'] ?? ''))))
        ->map(fn (string $p) => trim($p))
        ->filter()
        ->values();
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — 375 artboard --}}
    <div class="relative tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="px-[20px] pb-[80px] pt-[120px]" data-lum-villa-intro data-lum-intro-stagger="0.16">
            <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
            </div>

            <h1
                class="mt-[44px] w-full max-w-[335px] font-serif text-[28px] leading-[32px] tracking-[-0.25px] text-lum-espresso"
                data-lum-stay-intro-item
                data-lum-stay-intro-order="2"
            >{{ $page['title'] }}</h1>

            <div
                class="mt-[32px] flex w-full max-w-[335px] flex-col gap-[24px]"
                data-lum-stay-intro-item
                data-lum-stay-intro-order="3"
            >
                @forelse ($paragraphs as $paragraph)
                    <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply">
                        {!! nl2br(e($paragraph)) !!}
                    </p>
                @empty
                    <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso/40">—</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- TABLET — 960 artboard --}}
    <div class="relative hidden tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="px-[40px] pb-[100px] pt-[120px]" data-lum-villa-intro data-lum-intro-stagger="0.16">
            <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
            </div>

            <div class="mt-[48px] w-full max-w-[760px]">
                <h1
                    class="font-serif text-[36px] leading-[40px] tracking-[-0.25px] text-lum-espresso"
                    data-lum-stay-intro-item
                    data-lum-stay-intro-order="2"
                >{{ $page['title'] }}</h1>

                <div
                    class="mt-[36px] flex w-full flex-col gap-[28px]"
                    data-lum-stay-intro-item
                    data-lum-stay-intro-order="3"
                >
                    @forelse ($paragraphs as $paragraph)
                        <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply">
                            {!! nl2br(e($paragraph)) !!}
                        </p>
                    @empty
                        <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso/40">—</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP — 1920 artboard --}}
    <div class="relative hidden desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="px-[72px] pb-[140px] pt-[160px]" data-lum-villa-intro data-lum-intro-stagger="0.18">
            <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img, 'size' => 'l'])
            </div>

            <div class="mt-[64px] w-full max-w-[1100px]">
                <h1
                    class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso"
                    data-lum-stay-intro-item
                    data-lum-stay-intro-order="2"
                >{{ $page['title'] }}</h1>

                <div
                    class="mt-[44px] flex w-full flex-col gap-[32px]"
                    data-lum-stay-intro-item
                    data-lum-stay-intro-order="3"
                >
                    @forelse ($paragraphs as $paragraph)
                        <p class="lum-text-2 text-lum-espresso mix-blend-multiply">
                            {!! nl2br(e($paragraph)) !!}
                        </p>
                    @empty
                        <p class="lum-text-2 text-lum-espresso/40">—</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

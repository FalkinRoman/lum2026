@php
    $variant = $variant ?? 'mobile';
    $href = route('blog.show', $post['slug']);
@endphp

@if ($variant === 'mobile')
    <article class="relative h-[440px] w-[335px] overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory">
        <div class="absolute left-[28px] top-[28px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">
            <span>{{ $post['tags'][0] }}</span>
            <span class="size-[3px] rounded-full bg-lum-ground"></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        <h2 class="absolute left-[28px] top-[69px] w-[279px] font-serif text-[22px] leading-[24px] tracking-[0.19px] text-lum-espresso">{{ $post['title'] }}</h2>
        <p class="absolute left-[28px] top-[102px] w-[279px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply">{{ $post['excerpt'] }}</p>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 63,
            'classes' => 'absolute left-[244px] top-[396px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-green',
        ])
        <div class="absolute left-0 top-[240px] h-[241px] w-[335px] overflow-hidden">
            <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="absolute left-[-76px] top-0 h-[241px] w-[284px] max-w-none object-cover" width="284" height="241" loading="lazy">
        </div>
    </article>
@elseif ($variant === 'tablet')
    <article class="relative h-[320px] w-[920px] overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory">
        <div class="absolute left-0 top-0 h-full w-[446px] overflow-hidden">
            <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="absolute left-[-17px] top-[117px] h-[377px] w-[446px] max-w-none object-cover" width="446" height="377" loading="lazy">
        </div>
        <h2 class="absolute left-[24px] top-[27px] w-[328px] font-serif text-[28px] leading-[34px] tracking-[0.36px] text-lum-espresso">{{ $post['title'] }}</h2>
        <p class="absolute left-[470px] top-[32px] w-[426px] lum-text-2 text-lum-espresso mix-blend-multiply">{{ $post['excerpt'] }}</p>
        <div class="absolute left-[470px] top-[276px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">
            <span>{{ $post['tags'][0] }}</span>
            <span class="size-[3px] rounded-full bg-lum-ground"></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 81,
            'classes' => 'absolute left-[807px] top-[263px] lum-text-2 font-medium text-lum-green',
        ])
    </article>
@else
    <article class="relative h-[360px] w-[703px] overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory">
        <div class="absolute left-0 top-0 h-full w-[378px] overflow-hidden">
            <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="absolute left-[-17px] top-[117px] h-[375px] w-[378px] max-w-none object-cover" width="378" height="375" loading="lazy">
        </div>
        <h2 class="absolute left-[24px] top-[28px] w-[328px] font-serif text-[32px] leading-[36px] text-lum-espresso">{{ $post['title'] }}</h2>
        <p class="absolute left-[396px] top-[32px] w-[275px] lum-text-2 text-lum-espresso mix-blend-multiply">{{ $post['excerpt'] }}</p>
        <div class="absolute left-[396px] top-[324px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">
            <span>{{ $post['tags'][0] }}</span>
            <span class="size-[3px] rounded-full bg-lum-ground"></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 81,
            'classes' => 'absolute left-[588px] top-[311px] lum-text-2 font-medium text-lum-green',
        ])
    </article>
@endif

@php
    $variant = $variant ?? 'mobile';
    $href = route('blog.show', ['slug' => $post['slug'], 'from' => 'blog']);
    $theme = $post['theme'] ?? 'cream';

    $palette = match ($theme) {
        'dark' => [
            'bg' => $variant === 'mobile' ? 'bg-lum-espresso' : 'bg-lum-slate',
            'title' => 'text-lum-ivory',
            'body' => 'text-lum-ivory',
            'tags' => 'text-lum-ivory/40',
            'dot' => 'bg-lum-ivory/40',
            'link' => 'text-lum-rose',
            'line' => 'rose',
        ],
        'muted' => [
            'bg' => 'bg-lum-espresso/16',
            'title' => 'text-lum-espresso',
            'body' => 'text-lum-espresso',
            'tags' => 'text-lum-espresso/40',
            'dot' => 'bg-lum-espresso/40',
            'link' => 'text-lum-green',
            'line' => 'green',
        ],
        default => [
            'bg' => 'bg-lum-cream',
            'title' => 'text-lum-espresso',
            'body' => 'text-lum-espresso',
            'tags' => 'text-lum-espresso/40',
            'dot' => 'bg-lum-espresso/40',
            'link' => 'text-lum-green',
            'line' => 'green',
        ],
    };

    $mobileTitleClass = ($theme === 'dark')
        ? 'absolute left-[28px] top-[69px] w-[279px] line-clamp-2 overflow-hidden font-serif text-[22px] leading-[24px] tracking-[0.19px]'
        : 'absolute left-[28px] top-[69px] w-[279px] overflow-hidden text-ellipsis font-serif text-[22px] leading-[24px] tracking-[0.19px] whitespace-nowrap';

    $mobileBodyClass = ($theme === 'dark')
        ? 'absolute left-[28px] top-[124px] w-[279px] line-clamp-4 overflow-hidden text-[14px] leading-[22px] tracking-[0.1px]'
        : 'absolute left-[28px] top-[102px] w-[279px] line-clamp-4 overflow-hidden text-[14px] leading-[22px] tracking-[0.1px]';

    $titleLimit = match ($variant) {
        'mobile' => 52,
        'tablet' => 44,
        default => 44,
    };

    $cardTitle = \Illuminate\Support\Str::limit($post['title'], $titleLimit);
@endphp

@if ($variant === 'mobile')
    <article @class(['relative h-[440px] w-full overflow-hidden shadow-[3px_3px_0_0_rgba(0,0,0,0.25)]', $palette['bg']])>
        <div @class(['absolute left-[28px] top-[28px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px]', $palette['tags']])>
            <span>{{ $post['tags'][0] }}</span>
            <span @class(['size-[3px] rounded-full', $palette['dot']])></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        <h2 @class([$mobileTitleClass, $palette['title']])>{{ $cardTitle }}</h2>
        <p @class([$mobileBodyClass, $palette['body']])>{{ $post['excerpt'] }}</p>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 63,
            'lineTone' => $palette['line'],
            'classes' => 'absolute bottom-[28px] right-[28px] !items-end text-[12px] font-medium leading-[12px] tracking-[0.6px] ' . $palette['link'],
        ])
        <div class="absolute left-[-80px] top-[240px] h-[241px] w-[284px] overflow-hidden">
            <div class="absolute left-0 top-0 h-[236px] w-[280px] rotate-1">
                <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="h-full w-full object-cover" width="280" height="236" loading="lazy">
            </div>
        </div>
    </article>
@elseif ($variant === 'tablet')
    <article @class(['relative h-[320px] w-full overflow-hidden shadow-[3px_3px_0_0_rgba(0,0,0,0.25)]', $palette['bg']])>
        <div class="absolute left-0 top-0 h-full w-[446px] overflow-hidden">
            <div class="absolute left-[-17px] top-[117px] h-[377px] w-[446px] rotate-1">
                <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="h-full w-full object-cover" width="446" height="377" loading="lazy">
            </div>
        </div>
        <h2 @class(['absolute left-[24px] top-[27px] w-[328px] line-clamp-2 overflow-hidden font-serif text-[28px] leading-[34px] tracking-[0.36px]', $palette['title']])>{{ $cardTitle }}</h2>
        <p @class(['absolute left-[470px] top-[32px] w-[426px] lum-text-2', $palette['body']])>{{ $post['excerpt'] }}</p>
        <div @class(['absolute left-[470px] top-[276px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px]', $palette['tags']])>
            <span>{{ $post['tags'][0] }}</span>
            <span @class(['size-[3px] rounded-full', $palette['dot']])></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 81,
            'lineTone' => $palette['line'],
            'classes' => 'absolute left-[807px] top-[263px] lum-text-2 font-medium ' . $palette['link'],
        ])
    </article>
@else
    <article @class(['relative h-[360px] w-full overflow-hidden shadow-[3px_3px_0_0_rgba(0,0,0,0.25)]', $palette['bg']])>
        <div class="absolute left-0 top-0 h-full w-[378px] overflow-hidden">
            <div class="absolute left-[-17px] top-[117px] h-[375px] w-[378px] rotate-1">
                <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="h-full w-full object-cover" width="378" height="375" loading="lazy">
            </div>
        </div>
        <h2 @class(['absolute left-[24px] top-[28px] w-[328px] line-clamp-2 overflow-hidden font-serif text-[32px] leading-[36px]', $palette['title']])>{{ $cardTitle }}</h2>
        <p @class(['absolute left-[396px] top-[32px] w-[275px] lum-text-2', $palette['body']])>{{ $post['excerpt'] }}</p>
        <div @class(['absolute left-[396px] top-[324px] flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px]', $palette['tags']])>
            <span>{{ $post['tags'][0] }}</span>
            <span @class(['size-[3px] rounded-full', $palette['dot']])></span>
            <span>{{ $post['tags'][1] }}</span>
        </div>
        @include('lum.partials.link-read-more', [
            'img' => $img,
            'href' => $href,
            'lineWidth' => 81,
            'lineTone' => $palette['line'],
            'classes' => 'absolute left-[588px] top-[311px] lum-text-2 font-medium ' . $palette['link'],
        ])
    </article>
@endif

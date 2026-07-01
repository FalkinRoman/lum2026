@php
    $photo = $item['photo'] ?? 'dining/detail/shared/menu-item.webp';
@endphp

@if ($variant === 'mob')
    <article class="overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory p-[6px]" data-lum-villa-card>
        <img src="{{ $img($photo) }}" alt="" class="h-[320px] w-full object-cover" width="323" height="320" loading="lazy">
        <div class="px-[18px] pb-[18px] pt-[24px] text-center">
            <h3 class="font-serif text-[20px] font-medium leading-[20px] text-lum-ground">{{ $item['name'] }}</h3>
            <p class="mt-[16px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso/40">{{ $item['description'] }}</p>
            <p class="mt-[32px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-espresso">{{ $item['price'] }}</p>
        </div>
    </article>
@elseif ($variant === 'tab')
    <article class="h-[600px] overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory p-[12px]" data-lum-villa-card>
        <img src="{{ $img($photo) }}" alt="" class="h-[360px] w-full object-cover" width="429" height="360" loading="lazy">
        <div class="px-[12px] pb-[12px] pt-[24px] text-center">
            <h3 class="font-serif text-[24px] font-medium leading-[24px] text-lum-ground">{{ $item['name'] }}</h3>
            <p class="mt-[16px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso/40">{{ $item['description'] }}</p>
            <p class="mt-[115px] text-[14px] font-medium uppercase leading-[25px] tracking-[0.16px] text-lum-espresso">{{ $item['price'] }}</p>
        </div>
    </article>
@else
    <article class="flex h-[280px] overflow-hidden border border-dashed border-lum-espresso bg-lum-ivory p-[12px]" data-lum-villa-card>
        <img src="{{ $img($photo) }}" alt="" class="size-[256px] shrink-0 object-cover" width="256" height="256" loading="lazy">
        <div class="flex min-w-0 flex-1 flex-col px-[20px] py-[20px]">
            <h3 class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-ground">{{ $item['name'] }}</h3>
            <p class="mt-[16px] flex-1 text-[18px] leading-[26px] tracking-[0.1px] text-lum-espresso/40">{{ $item['description'] }}</p>
            <p class="text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-espresso">{{ $item['price'] }}</p>
        </div>
    </article>
@endif

<?php

return [

    /*
    | Exely (Travelline) Booking Engine integration.
    | Scripts from vendor archive: BE-INT-lum-residence_2026-07-16
    */
    'enabled' => (bool) env('EXELY_ENABLED', true),

    'integration_id' => env('EXELY_INTEGRATION_ID', 'BE-INT-lum-residence_2026-07-16'),

    /*
    | Hotels registered in the integration package.
    | Map villas to hotel_id + room_type_id in Filament → Villas.
    */
    'hotels' => [
        '502887' => [
            'label' => 'LUM RESIDENCE',
            'room_types' => [
                '5015382' => 'Deluxe Double Room',
                '5015383' => 'Deluxe Double Room with Balcony',
                '5015806' => 'Family room',
                '5017919' => 'Deluxe Triple Room',
                '5033813' => 'Small double room',
            ],
            'offers' => [
                '10099207' => 'Season 25-26',
                '10111950' => 'Best Deal: Season 25-26',
            ],
        ],
        '514444' => [
            'label' => 'LUM OCEAN',
            'room_types' => [
                '5077425' => 'Double room',
            ],
            'offers' => [
                '10163130' => 'Best daily rate',
            ],
        ],
    ],

    /*
    | Provisional slug → hotel_id until client confirms full mapping.
    | Oculus / Villas TBD — leave null → multi search on those pages.
    */
    'villa_hotels' => [
        'residence' => env('EXELY_HOTEL_RESIDENCE', '502887'),
        'ocean' => env('EXELY_HOTEL_OCEAN', '514444'),
        'villas' => env('EXELY_HOTEL_VILLAS', null),
        'oculus' => env('EXELY_HOTEL_OCULUS', null),
    ],

];

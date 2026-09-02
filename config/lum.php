<?php

return [

    /*
    | Emails allowed to access Filament (/admin). Comma-separated in .env.
    | Empty on production = nobody new; existing is_admin users still work.
    */
    'admin_emails' => array_values(array_filter(array_map(
        static fn (string $email): string => strtolower(trim($email)),
        explode(',', (string) env('ADMIN_EMAILS', '')),
    ))),

];

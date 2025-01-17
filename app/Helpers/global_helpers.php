<?php
/* create unique slug */
if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name): string
    {
        $modelClass = "App\\Models\\$model";
        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model $modelClass not found.");
        }
        $slug = \Str::slug($name);
        $count = 2;
        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = \Str::slug($name . '-' . $count);
            $count++;
        }
        return $slug;
    }
}
if (!function_exists('currencyPosition')) {
    function currencyPosition($price): string
    {
        if (config('settings.site_currency_icon_position') === 'left') {
            return config('settings.site_currency_icon') . $price;
        } else {
            return $price . config('settings.site_currency_icon');
        }
    }
}
/* admin side bar active */
if (!function_exists('setSidebarActive')) {
    function setSidebarActive(array $routes)
    {
        foreach($routes as $route){
            if(request()->routeIs($route)){
                return 'active';
            }
        }
        return '';
    }
}
if (!function_exists('insertBreaks')) {
    function insertBreaks($text, $wordsPerLine =6)
    {
        $words = explode(' ', $text); // Split the string into words
        $chunks = array_chunk($words, $wordsPerLine); // Split into chunks of 5 words
        return implode('<br>', array_map(fn($chunk) => implode(' ', $chunk), $chunks));
    }
}
<?php

use Illuminate\Support\Facades\App;

if (!function_exists('l')) {
    /**
     * Localize a value that may be:
     *  - a plain string  (returned as-is)
     *  - an array/JSON like ['az' => '...', 'en' => '...', 'ru' => '...']
     *
     * Falls back to Azerbaijani if the requested locale is missing.
     */
    function l($value, ?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();
        if (is_array($value)) {
            if (!empty($value[$locale])) return (string) $value[$locale];
            if (!empty($value['az']))    return (string) $value['az'];
            $first = array_filter($value, fn ($v) => $v !== '' && $v !== null);
            return $first ? (string) reset($first) : '';
        }
        if (is_string($value)) return $value;
        return '';
    }
}

if (!function_exists('l_from_db')) {
    /**
     * Localize a DB row that has separate columns per locale (name, name_en, name_ru).
     * Base column carries Azerbaijani.
     */
    function l_from_db($model, string $base, ?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();
        if ($locale === 'az') return (string) ($model->$base ?? '');
        $col = $base . '_' . $locale;
        $val = $model->$col ?? null;
        if (!empty($val)) return (string) $val;
        return (string) ($model->$base ?? '');
    }
}

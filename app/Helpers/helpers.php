<?php

if (!function_exists('translateJsonKeysToPersian')) {
    function translateJsonKeysToPersian($array)
    {
        $translations = [
            'delivery_date'=>'تاریخ تحویل',
            'original'=>'از',
            'changed'=>'به',
            'added'=>'اضافه شده',
            'removed'=>'حذف شده',
            'modified'=>'تغییر یافته',
            'cpu'=>'پردازنده',
            'ram'=>'رم',
            'internalHardDisk'=>'هارد اینترنال',
            'internalHardDisk_property_code'=>'کد اموال هارد اینترنال',
        ];

        $translatedArray = [];

        foreach ($array as $key => $value) {
            $farsiKey = $translations[$key] ?? $key;
            if (is_array($value)) {
                $translatedArray[$farsiKey] = translateJsonKeysToPersian($value);
            } else {
                $translatedArray[$farsiKey] = $value;
            }
        }

        return $translatedArray;
    }
}

<?php

if (!defined('TRANSLATIONS')) {
    define('TRANSLATIONS', [
        'delivery_date' => 'تاریخ تحویل',
        'property_code' => 'کد اموال',
        'status' => 'وضعیت',
        'personnel' => 'پرسنل',
        'info' => 'اطلاعات',
        'seal_code' => 'کد پلمپ',
        'original' => 'از',
        'changed' => 'به',
        'added' => 'اضافه شده',
        'removed' => 'حذف شده',
        'modified' => 'تغییر یافته',
        'internalHardDisks' => 'هارد اینترنال',
        'internalHardDisk' => 'هارد اینترنال',
        'internalHardDisk_property_code' => 'کد اموال هارد اینترنال',
        'case' => 'کیس',
        'power' => 'منبع تغذیه',
        'motherboard' => 'مادربورد',
        'cpu' => 'پردازنده',
        'graphicCard' => 'کارت گرافیک',
        'ram' => 'رم',
        'ram_size' => 'سایز رم',
        'generation' => 'نسل',
        'cpu_slot_type' => 'نوع اسلات پردازنده',
        'cpu_slots_number' => 'تعداد اسلات پردازنده',
        'ram_slots_number' => 'تعداد اسلات رم',
        'ram_slot_type' => 'نوع اسلات رم',
        'voltage' => 'ولتاژ',
        'monitor' => 'مانیتور',
        'model' => 'مدل',
        'type' => 'نوع',
        'size' => 'سایز',
        'frequency' => 'فرکانس',
        'channels' => 'کانال',
        'brand_info' => 'برند',
    ]);
}

if (!function_exists('translateKeysToPersian')) {
    function translateKeysToPersian($array)
    {
        $translations = TRANSLATIONS;
        $translatedArray = [];

        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $farsiKey = $translations[$key] ?? $key;
                if (is_array($value)) {
                    $translatedArray[$farsiKey] = translateKeysToPersian($value);
                } else {
                    $translatedArray[$farsiKey] = $value;
                }
            }
        }

        return $translatedArray;
    }
}

if (!function_exists('translateKeysToEnglish')) {
    function translateKeysToEnglish($array)
    {
        $translations = array_flip(TRANSLATIONS);
        $translatedArray = [];

        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $englishKey = $translations[$key] ?? $key;
                if (is_array($value)) {
                    $translatedArray[$englishKey] = translateKeysToEnglish($value);
                } else {
                    $translatedArray[$englishKey] = $value;
                }
            }
        }

        return $translatedArray;
    }
}


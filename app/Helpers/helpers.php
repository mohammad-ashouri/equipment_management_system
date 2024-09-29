<?php

if (!function_exists('translateJsonKeysToPersian')) {
    function translateJsonKeysToPersian($array)
    {
        $translations = [
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
            'internalHardDisk_property_code' => 'کد اموال هارد اینترنال',
            'case' => 'کیس',
            'power' => 'منبع تغذیه',
            'motherboard' => 'مادربورد',
            'cpu' => 'پردازنده',
            'graphicCard' => 'کارت گرافیک',
            'ram' => 'رم',
            'internalHardDisk' => 'هارد اینترنال',
        ];

        $translatedArray = [];

        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $farsiKey = $translations[$key] ?? $key;
                if (is_array($value)) {
                    $translatedArray[$farsiKey] = translateJsonKeysToPersian($value);
                } else {
                    $translatedArray[$farsiKey] = $value;
                }
            }
        } else {
            $translatedArray = [];
        }

        return $translatedArray;
    }
}

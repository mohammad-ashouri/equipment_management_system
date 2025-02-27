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
        'building' => 'ساختمان',
        'name' => 'نام',
        'address' => 'آدرس',
        'power_type' => 'منبع تغذیه',
        'parts_number' => 'تعداد قطعات',
        'head_type' => 'نوع هد',
        'connectivity_type' => 'نوع اتصال',
        'material' => 'جنس',
        'desktop_type' => 'نوع میزکار',
        'drawer_number' => 'تعداد کشو',
        'lock' => 'قفل',
        'tuner_numbers' => 'تعداد ورودی آنتن',
        'weight' => 'وزن',
        'capacity' => 'فضا',
        'color' => 'رنگ',
        'door_number' => 'تعداد در',
        'key_number' => 'تعداد آویز کلید',
        'ports_number' => 'تعداد پورت',
        'input_ports_number' => 'تعداد پورت ورودی',
        'output_ports_number' => 'تعداد پورت خروجی',
        'graphic_card' => 'کارت گرافیک',
        'monitor_size' => 'سایز مانیتور',
        'internal_memory' => 'حافظه داخلی',
        'simcard_number' => 'تعداد سیمکارت',
        'antennas_number' => 'تعداد آنتن',
        'function_type' => 'نوع عملکرد',
        'units_number' => 'تعداد یونیت',
        'number' => 'شماره',
        'serial' => 'شماره سریال',
        'type_use' => 'نوع استفاده',
        'height' => 'ارتفاع',
        'width' => 'عرض',
        'length' => 'طول',
        'fan' => 'دارای فن',
        'stairs_number' => 'تعداد پله',
        'pendants_number' => 'تعداد آویز',
        'flames_number' => 'تعداد شعله',
        'liter_capacity' => 'ظرفیت به لیتر',
        'cold_water_tap' => 'شیر آب سرد',
        'warm_water_tap' => 'شیر آب گرم',
        'floors_number' => 'تعداد طبقه',
        'publication' => 'انتشارات',
        'writer' => 'نویسنده',
        'book_subject' => 'عنوان کتاب',
        'book' => 'کتاب',
        'chair' => 'صندلی',
        'table' => 'میز',
        'library' => 'کتابخانه',
        'drawer_file_cabinet' => 'فایل کشویی',
        'mode' => 'حالت',
        'battery_type' => 'نوع باتری',
        'flashlight' => 'چراغ قوه',
        'mihrab' => 'محراب',
        'suitable_for' => 'مناسب برای',
        'tank' => 'منبع',
        'refrigerator' => 'یخچال',
        'room_number' => 'شماره اتاق',
        'description' => 'توضیحات',
        'mobile' => 'تلفن همراه',
        'headset' => 'هدست',
        'camera_ram' => 'رم دوربین',
        'pbx' => 'دستگاه سانترال',
        'satellite_switches' => 'سوییچ ماهواره',
        'nvr' => 'NVR',
    ]);
}

if (!function_exists('translateKeysToPersian')) {
    function translateKeysToPersian($array): array
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
    function translateKeysToEnglish($array): array
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


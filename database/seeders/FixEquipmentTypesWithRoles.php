<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixEquipmentTypesWithRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipmentTypes = [
            ['name' => 'monitor', 'persian_name' => 'مانیتور', 'accessible_roles' => [1, 2]],
            ['name' => 'case', 'persian_name' => 'کیس', 'accessible_roles' => [1, 2]],
            ['name' => 'mouse', 'persian_name' => 'موس', 'accessible_roles' => [1, 2]],
            ['name' => 'keyboard', 'persian_name' => 'صفحه کلید', 'accessible_roles' => [1, 2]],
            ['name' => 'headset', 'persian_name' => 'هدست', 'accessible_roles' => [1, 2]],
            ['name' => 'printer', 'persian_name' => 'پرینتر', 'accessible_roles' => [1, 2]],
            ['name' => 'scanner', 'persian_name' => 'اسکنر', 'accessible_roles' => [1, 2]],
            ['name' => 'copy_machine', 'persian_name' => 'دستگاه کپی', 'accessible_roles' => [1, 2]],
            ['name' => 'voip', 'persian_name' => 'VOIP', 'accessible_roles' => [1, 2]],
            ['name' => 'modem', 'persian_name' => 'مودم', 'accessible_roles' => [1, 2]],
            ['name' => 'switch', 'persian_name' => 'سوییچ', 'accessible_roles' => [1, 2]],
            ['name' => 'rack', 'persian_name' => 'رک', 'accessible_roles' => [1, 2]],
            ['name' => 'dongle', 'persian_name' => 'دانگل', 'accessible_roles' => [1, 2]],
            ['name' => 'external_hard_disk', 'persian_name' => 'هارد اکسترنال', 'accessible_roles' => [1, 2]],
            ['name' => 'phone', 'persian_name' => 'تلفن رومیزی', 'accessible_roles' => [1, 2]],
            ['name' => 'television', 'persian_name' => 'تلوزیون', 'accessible_roles' => [1, 2]],
            ['name' => 'mobile', 'persian_name' => 'تلفن همراه', 'accessible_roles' => [1, 2]],
            ['name' => 'tablet', 'persian_name' => 'تبلت', 'accessible_roles' => [1, 2]],
            ['name' => 'dvb', 'persian_name' => 'کارت DVB', 'accessible_roles' => [1, 2]],
            ['name' => 'camera_holder', 'persian_name' => 'پایه دوربین', 'accessible_roles' => [1, 2]],
            ['name' => 'simcard', 'persian_name' => 'سیمکارت', 'accessible_roles' => [1, 2]],
            ['name' => 'punch_wrench', 'persian_name' => 'آچار پانچ', 'accessible_roles' => [1, 2]],
            ['name' => 'socket_wrench', 'persian_name' => 'آچار سوکت', 'accessible_roles' => [1, 2]],
            ['name' => 'stripper_wrench', 'persian_name' => 'آچار استریپر', 'accessible_roles' => [1, 2]],
            ['name' => 'cable_tester', 'persian_name' => 'تستر شبکه', 'accessible_roles' => [1, 2]],
            ['name' => 'kvm', 'persian_name' => 'سوییچ kvm', 'accessible_roles' => [1, 2]],
            ['name' => 'lantv', 'persian_name' => 'Lan TV', 'accessible_roles' => [1, 2]],
            ['name' => 'speaker', 'persian_name' => 'اسپیکر', 'accessible_roles' => [1, 2]],
            ['name' => 'attendance_system', 'persian_name' => 'دستگاه حضور و غیاب', 'accessible_roles' => [1, 2]],
            ['name' => 'cctv', 'persian_name' => 'دوربین مدار بسته', 'accessible_roles' => [1, 2]],
            ['name' => 'recorder', 'persian_name' => 'رکوردر', 'accessible_roles' => [1, 2]],
            ['name' => 'webcam', 'persian_name' => 'وبکم', 'accessible_roles' => [1, 2]],
            ['name' => 'flash_memory', 'persian_name' => 'فلش مموری', 'accessible_roles' => [1, 2]],
            ['name' => 'ups', 'persian_name' => 'ups', 'accessible_roles' => [1, 2]],
            ['name' => 'satellite_dish', 'persian_name' => 'دیش ماهواره', 'accessible_roles' => [1, 2]],
            ['name' => 'camera_lens', 'persian_name' => 'لنز دوربین', 'accessible_roles' => [1, 2]],
            ['name' => 'satellite_finder', 'persian_name' => 'فایندر ماهواره', 'accessible_roles' => [1, 2]],
            ['name' => 'sound_card', 'persian_name' => 'کارت صدا', 'accessible_roles' => [1, 2]],
            ['name' => 'video_projector', 'persian_name' => 'ویدئو پروژکتور', 'accessible_roles' => [1, 2]],
            ['name' => 'video_projector_curtain', 'persian_name' => 'پرده ویدئو پروژکتور', 'accessible_roles' => [1, 2]],
            ['name' => 'microphone', 'persian_name' => 'میکروفون', 'accessible_roles' => [1, 2]],
            ['name' => 'battery_charger', 'persian_name' => 'شارژر باتری', 'accessible_roles' => [1, 2]],
            ['name' => 'camera', 'persian_name' => 'دوربین', 'accessible_roles' => [1, 2]],
            ['name' => 'chair', 'persian_name' => 'صندلی', 'accessible_roles' => [1, 3]],
            ['name' => 'table', 'persian_name' => 'میز', 'accessible_roles' => [1, 3]],
            ['name' => 'fire_extinguisher', 'persian_name' => 'کپسول آتش نشانی', 'accessible_roles' => [1, 3]],
            ['name' => 'radio_wireless', 'persian_name' => 'رادیو وایرلس', 'accessible_roles' => [1, 2]],
            ['name' => 'access_point', 'persian_name' => 'اکسس پوینت', 'accessible_roles' => [1, 2]],
            ['name' => 'router', 'persian_name' => 'روتر', 'accessible_roles' => [1, 2]],
            ['name' => 'refrigerator', 'persian_name' => 'یخچال', 'accessible_roles' => [1, 3]],
            ['name' => 'laptop', 'persian_name' => 'لپ تاپ', 'accessible_roles' => [1, 2]],
            ['name' => 'blower', 'persian_name' => 'دستگاه دمنده', 'accessible_roles' => [1, 3]],
            ['name' => 'key_box', 'persian_name' => 'جعبه کلید', 'accessible_roles' => [1, 3]],
            ['name' => 'drawer_file_cabinet', 'persian_name' => 'فایل کشویی', 'accessible_roles' => [1, 3]],
            ['name' => 'air_conditioner', 'persian_name' => 'کولر گازی', 'accessible_roles' => [1, 3]],
            ['name' => 'heater', 'persian_name' => 'بخاری', 'accessible_roles' => [1, 3]],
            ['name' => 'ladder', 'persian_name' => 'نردبان', 'accessible_roles' => [1, 3]],
            ['name' => 'ping_pong_table', 'persian_name' => 'میز پینگ پنگ', 'accessible_roles' => [1, 3]],
            ['name' => 'microwave', 'persian_name' => 'مایکروفر', 'accessible_roles' => [1, 3]],
            ['name' => 'fan', 'persian_name' => 'پنکه', 'accessible_roles' => [1, 3]],
            ['name' => 'vaccum_cleaner', 'persian_name' => 'جاروبرقی', 'accessible_roles' => [1, 3]],
            ['name' => 'coat_hanger', 'persian_name' => 'جالباسی', 'accessible_roles' => [1, 3]],
            ['name' => 'shredder', 'persian_name' => 'کاغذ خردکن', 'accessible_roles' => [1, 3]],
            ['name' => 'oven', 'persian_name' => 'اجاق', 'accessible_roles' => [1, 3]],
            ['name' => 'water_purifier', 'persian_name' => 'تصفیه کننده آب', 'accessible_roles' => [1, 3]],
            ['name' => 'tea_maker', 'persian_name' => 'چای ساز', 'accessible_roles' => [1, 3]],
            ['name' => 'samovar', 'persian_name' => 'سماور', 'accessible_roles' => [1, 3]],
            ['name' => 'whiteboard', 'persian_name' => 'تخته وایت بورد', 'accessible_roles' => [1, 3]],
            ['name' => 'water_dispenser', 'persian_name' => 'آبسردکن', 'accessible_roles' => [1, 3]],
            ['name' => 'noticeboard', 'persian_name' => 'تخته اعلانات', 'accessible_roles' => [1, 3]],
            ['name' => 'paper_cutter', 'persian_name' => 'برش دهنده کاغذ', 'accessible_roles' => [1, 3]],
            ['name' => 'spring_binding', 'persian_name' => 'فنرزن کاغذ', 'accessible_roles' => [1, 3]],
            ['name' => 'hot_glue_binding', 'persian_name' => 'دستگاه صحافی چسب گرم', 'accessible_roles' => [1, 3]],
            ['name' => 'suggestion_box', 'persian_name' => 'صندوق پیشنهادات', 'accessible_roles' => [1, 3]],
            ['name' => 'closet', 'persian_name' => 'کمد', 'accessible_roles' => [1, 3]],
            ['name' => 'laminating_machine', 'persian_name' => 'دستگاه سلفون کش و لمینیت', 'accessible_roles' => [1, 3]],
            ['name' => 'library', 'persian_name' => 'کتابخانه', 'accessible_roles' => [1, 3]],
            ['name' => 'bed', 'persian_name' => 'تخت خواب', 'accessible_roles' => [1, 3]],
            ['name' => 'front_furniture_table', 'persian_name' => 'جلومبلی/میز عسلی', 'accessible_roles' => [1, 3]],
            ['name' => 'book', 'persian_name' => 'کتاب', 'accessible_roles' => [1, 3]],
            ['name' => 'whiteboard_holder', 'persian_name' => 'پایه تخته وایت بورد', 'accessible_roles' => [1, 3]],
            ['name' => 'shoe_cabinet', 'persian_name' => 'جاکفشی', 'accessible_roles' => [1, 3]],
            ['name' => 'safe', 'persian_name' => 'گاو صندوق', 'accessible_roles' => [1, 3]],
            ['name' => 'thermometer', 'persian_name' => 'تب سنج', 'accessible_roles' => [1, 3]],
            ['name' => 'electric_panel', 'persian_name' => 'تابلو برق', 'accessible_roles' => [1, 3]],
            ['name' => 'flashlight', 'persian_name' => 'چراغ قوه', 'accessible_roles' => [1, 3]],
            ['name' => 'mihrab', 'persian_name' => 'محراب', 'accessible_roles' => [1, 3]],
            ['name' => 'bracket', 'persian_name' => 'براکت', 'accessible_roles' => [1, 3]],
            ['name' => 'flower_pot', 'persian_name' => 'استند گلدان', 'accessible_roles' => [1, 3]],
            ['name' => 'camera_ram', 'persian_name' => 'رم دوربین', 'accessible_roles' => [1, 2]],
            ['name' => 'pbx', 'persian_name' => 'دستگاه سانترال', 'accessible_roles' => [1, 2]],
            ['name' => 'satellite_switch', 'persian_name' => 'سوییچ ماهواره', 'accessible_roles' => [1, 2]],
            ['name' => 'nvr', 'persian_name' => 'nvr', 'accessible_roles' => [1, 2]],
            ['name' => 'lmb', 'persian_name' => 'lmb', 'accessible_roles' => [1, 2]],
            ['name' => 'set_top_box', 'persian_name' => 'گیرنده دیجیتال', 'accessible_roles' => [1, 2]],
            ['name' => 'light_holder', 'persian_name' => 'پایه نور', 'accessible_roles' => [1, 2]],
            ['name' => 'battery_cabinet', 'persian_name' => 'کابینت باتری', 'accessible_roles' => [1, 2]],
            ['name' => 'light', 'persian_name' => 'نور', 'accessible_roles' => [1, 2]],
            ['name' => 'camera_slider', 'persian_name' => 'اسلایدر دوربین', 'accessible_roles' => [1, 2]],
            ['name' => 'server', 'persian_name' => 'سرور', 'accessible_roles' => [1, 2]],
            ['name' => 'storage', 'persian_name' => 'Storage', 'accessible_roles' => [1, 2]],
            ['name' => 'iranian_cooler', 'persian_name' => 'کولر آبی', 'accessible_roles' => [1, 3]],
            ['name' => 'iranian_cooler', 'persian_name' => 'مبلمان', 'accessible_roles' => [1, 3]],
            ['name' => 'digital_pen', 'persian_name' => 'قلم نوری', 'accessible_roles' => [1, 2]],
            ['name' => 'crossover', 'persian_name' => 'کراس', 'accessible_roles' => [1, 3]],
            ['name' => 'external_writer', 'persian_name' => 'رایتر اکسترنال', 'accessible_roles' => [1, 2]],
        ];

        foreach ($equipmentTypes as $type) {
            EquipmentType::firstOrCreate(
                ['name' => $type['name']], // شرط بررسی وجود
                [
                    'persian_name' => $type['persian_name'],
                    'accessible_roles' => json_encode($type['accessible_roles'])
                ] // داده‌های ایجاد در صورت عدم وجود
            );
        }

    }
}

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
        EquipmentType::create(['name'=>'monitor','persian_name'=>'مانیتور','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'case','persian_name'=>'کیس','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'mouse','persian_name'=>'موس','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'keyboard','persian_name'=>'صفحه کلید','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'headset','persian_name'=>'هدست','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'printer','persian_name'=>'پرینتر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'scanner','persian_name'=>'اسکنر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'copy_machine','persian_name'=>'دستگاه کپی','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'voip','persian_name'=>'VOIP','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'modem','persian_name'=>'مودم','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'switch','persian_name'=>'سوییچ','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'rack','persian_name'=>'رک','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'dongle','persian_name'=>'دانگل','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'external_hard_disk','persian_name'=>'هارد اکسترنال','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'phone','persian_name'=>'تلفن رومیزی','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'television','persian_name'=>'تلوزیون','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'mobile','persian_name'=>'موبایل','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'tablet','persian_name'=>'تبلت','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'dvb','persian_name'=>'کارت DVB','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'camera_holder','persian_name'=>'پایه دوربین','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'simcard','persian_name'=>'سیمکارت','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'punch_wrench', 'persian_name' => 'آچار شبکه','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'socket_wrench', 'persian_name' => 'آچار سوکت','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'stripper_wrench', 'persian_name' => 'آچار استریپر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'cable_tester', 'persian_name' => 'تستر شبکه','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'kvm', 'persian_name' => 'سوییچ kvm','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'lantv', 'persian_name' => 'Lan TV','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'speaker', 'persian_name' => 'اسپیکر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'attendance_system', 'persian_name' => 'دستگاه حضور و غیاب','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'cctv', 'persian_name' => 'دوربین مدار بسته','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'recorder', 'persian_name' => 'رکوردر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'webcam', 'persian_name' => 'وبکم','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'flash_memory', 'persian_name' => 'فلش مموری','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'ups', 'persian_name' => 'ups','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'satellite_dish', 'persian_name' => 'دیش ماهواره','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'camera_lens', 'persian_name' => 'لنز دوربین','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'satellite_finder', 'persian_name' => 'فایندر ماهواره','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'sound_card', 'persian_name' => 'کارت صدا','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'video_projector', 'persian_name' => 'ویدئو پروژکتور','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'video_projector_curtain', 'persian_name' => 'پرده ویدئو پروژکتور','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'microphone', 'persian_name' => 'میکروفون','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'battery_charger', 'persian_name' => 'شارژر باتری','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'camera', 'persian_name' => 'دوربین','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'chair', 'persian_name' => 'صندلی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'table', 'persian_name' => 'میز','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'fire_extinguisher', 'persian_name' => 'کپسول آتش نشانی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'radio_wireless', 'persian_name' => 'رادیو وایرلس','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'access_point', 'persian_name' => 'اکسس پوینت','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'router', 'persian_name' => 'روتر','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name' => 'refrigerator', 'persian_name' => 'یخچال','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name'=>'laptop','persian_name'=>'لپ تاپ','accessible_roles'=>json_encode([1,2])]);
        EquipmentType::create(['name'=>'blower','persian_name'=>'دستگاه دمنده','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name'=>'key_box','persian_name'=>'جعبه کلید','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'drawer_file_cabinet', 'persian_name' => 'فایل کشویی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'air_conditioner', 'persian_name' => 'کولر گازی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'heater', 'persian_name' => 'بخاری برقی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'ladder', 'persian_name' => 'نردبان','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'ping_pong_table', 'persian_name' => 'میز پینگ پنگ','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'microwave', 'persian_name' => 'مایکروفر','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'fan', 'persian_name' => 'پنکه','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'vaccum_cleaner', 'persian_name' => 'جاروبرقی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'coat_hanger', 'persian_name' => 'جالباسی','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'shredder', 'persian_name' => 'کاغذ خردکن','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'oven', 'persian_name' => 'اجاق','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'water_purifier', 'persian_name' => 'تصفیه کننده آب','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'tea_maker', 'persian_name' => 'چای ساز','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'samovar', 'persian_name' => 'سماور','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'whiteboard', 'persian_name' => 'تخته وایت بورد','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'water_dispenser', 'persian_name' => 'آبسردکن','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'noticeboard', 'persian_name' => 'تخته اعلانات','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'paper_cutter', 'persian_name' => 'برش دهنده کاغذ','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'spring_binding', 'persian_name' => 'فنرزن کاغذ','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'hot_glue_binding', 'persian_name' => 'دستگاه صحافی چسب گرم','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'suggestion_box', 'persian_name' => 'صندوق پیشنهادات','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'closet', 'persian_name' => 'کمد','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'laminating_machine', 'persian_name' => 'دستگاه سلفون کش و لمینیت','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'library', 'persian_name' => 'کتابخانه','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'bed', 'persian_name' => 'تخت خواب','accessible_roles'=>json_encode([1,3])]);
        EquipmentType::create(['name' => 'front_furniture_tables', 'persian_name' => 'جلومبلی/میز عسلی','accessible_roles'=>json_encode([1,3])]);
    }
}

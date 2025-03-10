<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;


class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            ['name' => 'أمراض القلب والشرايين',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج مجموعة واسعة من الحالات التي تؤثر على القلب والأوعية الدموية. يشمل ذلك أمراض الشرايين التاجية، وارتفاع ضغط الدم، وفشل القلب، واضطرابات ضربات القلب، وغيرها.'],
            ['name' => 'الجراحة العامة',
             'description' => 'تخصص جراحي يتعامل مع مجموعة واسعة من الحالات الجراحية في مناطق مختلفة من الجسم.'],
            ['name' => 'الأمراض الباطنية',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج الأمراض التي تصيب الأعضاء الداخلية في الجسم.'],
            ['name' => 'الأمراض الجلدية',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج الأمراض التي تصيب الجلد والشعر والأظافر.'],
            ['name' => 'الأمراض العصبية',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج الأمراض التي تصيب الجهاز العصبي.'],
            ['name' => 'الأمراض النفسية',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج الاضطرابات النفسية.'],
            ['name' => 'الأمراض النسائية والتوليد',
             'description' => 'تخصص طبي يركز على صحة المرأة، بما في ذلك الحمل والولادة.'],
            ['name' => 'الأطفال',
             'description' => 'تخصص طبي يركز على صحة الأطفال.'],
            ['name' => 'الأورام',
             'description' => 'تخصص طبي يركز على تشخيص وعلاج الأورام السرطانية.'],
            ['name' => 'الأعصاب والجراحة العصبية',
             'description' => 'تخصص جراحي يركز على الجراحة التي تؤثر على الجهاز العصبي.'],

        ];


        foreach($specialties as $specialty){
            Specialty::create($specialty);
        }
    }
}





<?php
return [

    'required' => ':attribute مطلوب.',
    'string' => ':attribute يجب أن يكون نصًا.',
    'email' => ':attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'min' => ':attribute يجب أن يحتوي على الأقل :min حرف.',
    'max' => ':attribute يجب ألا يتجاوز :max حرف.',
    'confirmed' => ':attribute لا يتطابق مع تأكيده.',
    'unique' => ':attribute تم استخدامه من قبل.',
    'integer' => ':attribute يجب أن يكون عددًا صحيحًا.',
    'numeric' => ':attribute يجب أن يكون رقمًا.',
    'date' => ':attribute يجب أن يكون تاريخًا صالحًا.',
    'date_format' => ':attribute لا يتطابق مع الصيغة :format.',
    'after' => ':attribute يجب أن يكون تاريخًا لاحقًا لـ :date.',
    'before' => ':attribute يجب أن يكون تاريخًا سابقًا لـ :date.',
    'in' => ':attribute يجب أن يكون أحد القيم التالية: :values.',
    'not_in' => ':attribute يجب ألا يكون أحد القيم التالية: :values.',
    'exists' => ':attribute المحدد غير صالح.',
    'regex' => ':attribute غير صالح.',
    'url' => ':attribute يجب أن يكون رابطًا صالحًا.',
    'active_url' => ':attribute ليس رابطًا نشطًا.',
    'image' => ':attribute يجب أن يكون صورة.',
    'mimes' => ':attribute يجب أن يكون ملفًا من نوع: :values.',
    'mimetypes' => ':attribute يجب أن يكون ملفًا من نوع: :values.',
    'dimensions' => ':attribute يحتوي على أبعاد غير صالحة.',
    'file' => ':attribute يجب أن يكون ملفًا.',
    'size' => ':attribute يجب أن يكون حجمه :size كيلوبايت.',
    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string' => ':attribute يجب أن يكون بين :min و :max حرف.',
        'array' => ':attribute يجب أن يحتوي على عدد عناصر بين :min و :max.',
    ],
    'same' => ':attribute و :other يجب أن يتطابقا.',
    'different' => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits' => ':attribute يجب أن يكون :digits أرقام.',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max أرقام.',
    'password' => 'كلمة المرور غير صحيحة.',
    'boolean' => ':attribute يجب أن يكون قيمة منطقية (صحيح أو خطأ).',


    'attributes' => [
        'title' => 'العنوان',
        'subject' => 'الموضوع',
        'img' => 'الصورة',
        'advice' => 'النصيحة',
        'comment' => 'التعليق',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'is_doctor'=> 'صلاحية الطبيب',
        'reset_code' => 'رمز التحقق'
    ]


];

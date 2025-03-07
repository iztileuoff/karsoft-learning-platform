<?php

declare(strict_types=1);

return [
    'accepted'             => ':attribute ni qabul qilishingiz kerak.',
    'accepted_if'          => 'The :attribute must be accepted when :other is :value.',
    'active_url'           => ':attribute ga noto‘g‘ri URL kiritildi.',
    'after'                => ':attribute da sana :date dan keyin bo‘lishi kerak.',
    'after_or_equal'       => ':attribute da sana :date ga teng yoki undan keyin bo‘lishi kerak.',
    'alpha'                => ':attribute faqat harflarni qabul qilishi mumkin.',
    'alpha_dash'           => ':attribute faqat harflar, sonlar va chiziqchalarni qabul qilishi mumkin.',
    'alpha_num'            => ':attribute faqat harflar va sonlarni qabul qilishi mumkin.',
    'array'                => ':attribute qatordan iborat bo‘lishi kerak.',
    'ascii'                => 'The :attribute must only contain single-byte alphanumeric characters and symbols.',
    'before'               => ':attribute da sana :date gacha bo‘lishi kerak.',
    'before_or_equal'      => ':attribute da sana :date ga teng yoki undan oldin bo‘lishi kerak.',
    'between'              => [
        'array'   => ':attribute dagi elementlar soni :min va :max orasida bo‘lishi kerak.',
        'file'    => ':attribute dagi faylning hajmi :min va :max kilobayt orasida bo‘lishi kerak.',
        'numeric' => ':attribute ning qiymati :min va :max orasida bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :min va :max orasida bo‘lishi kerak.',
    ],
    'boolean'              => ':attribute maydoni faqat mantiqiy qiymatni qabul qiladi.',
    'can'                  => 'The :attribute field contains an unauthorized value.',
    'confirmed'            => ':attribute tasdiqlangani bilan mos kelmadi.',
    'contains'             => 'The :attribute field is missing a required value.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => ':attribute sana emas.',
    'date_equals'          => ':attribute sana :date ga teng bo‘lishi kerak.',
    'date_format'          => ':attribute maydoni :format formatga mos kelmadi.',
    'decimal'              => 'The :attribute must have :decimal decimal places.',
    'declined'             => 'The :attribute must be declined.',
    'declined_if'          => 'The :attribute must be declined when :other is :value.',
    'different'            => ':attribute va :other maydonlari farqli bo‘lishi kerak.',
    'digits'               => ':attribute :digits raqamdan iborat bo‘lishi kerak.',
    'digits_between'       => ':attribute uzunligi :min va :max orasida bo‘lishi kerak.',
    'dimensions'           => ':attribute noto‘g‘ri tasvir o‘lchamlarga ega.',
    'distinct'             => ':attribute maydoni takrorlanuvchi qiymatlardan iborat.',
    'doesnt_end_with'      => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with'    => 'The :attribute may not start with one of the following: :values.',
    'email'                => ':attribute haqiqiy elektron pochta manzili bo‘lishi kerak.',
    'ends_with'            => ':attribute quyidagi qiymatlarning biri bilan tugashi kerak: :values.',
    'enum'                 => 'The :attribute field value is not in the list of allowed values.',
    'exists'               => ':attribute uchun tanlangan qiymat noto‘g‘ri.',
    'extensions'           => 'The :attribute field must have one of the following extensions: :values.',
    'file'                 => ':attribute fayl bo‘lishi kerak.',
    'filled'               => ':attribute maydoni to‘ldirilishi shart.',
    'gt'                   => [
        'array'   => ':attribute dagi elementlar soni :value dan katta bo‘lishi kerak.',
        'file'    => ':attribute fayl hajmi :value kilobaytdan katta bo‘lishi kerak.',
        'numeric' => ':attribute maydoni :value dan katta bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :value dan katta bo‘lishi kerak.',
    ],
    'gte'                  => [
        'array'   => ':attribute dagi elementlar soni :value dan katta yoki teng bo‘lishi kerak.',
        'file'    => ':attribute fayl hajmi :value kilobaytdan katta yoki teng bo‘lishi kerak.',
        'numeric' => ':attribute maydoni :value dan katta yoki teng bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :value dan katta yoki teng bo‘lishi kerak.',
    ],
    'hex_color'            => 'The :attribute field must be a valid hexadecimal color.',
    'image'                => ':attribute tasvir (rasm) bo‘lishi kerak.',
    'in'                   => ':attribute uchun tanlangan qiymat xato.',
    'in_array'             => ':attribute maydonining qiymati :other da mavjud emas.',
    'integer'              => ':attribute butun son bo‘lishi kerak.',
    'ip'                   => ':attribute haqiqiy IP manzil bo‘lishi kerak.',
    'ipv4'                 => ':attribute haqiqiy IPv4 manzil bo‘lishi kerak.',
    'ipv6'                 => ':attribute haqiqiy IPv6 manzil bo‘lishi kerak.',
    'json'                 => ':attribute JSON qatori bo‘lishi kerak.',
    'list'                 => 'The :attribute field must be a list.',
    'lowercase'            => 'The :attribute must be lowercase.',
    'lt'                   => [
        'array'   => ':attribute dagi elementlar soni :value dan kichik bo‘lishi kerak.',
        'file'    => ':attribute dagi fayl hajmi :value kilobaytdan kichik bo‘lishi kerak.',
        'numeric' => ':attribute maydoni :value dan kichik bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :value dan kichik bo‘lishi kerak.',
    ],
    'lte'                  => [
        'array'   => ':attribute dagi elementlar soni :value dan kichik yoki teng bo‘lishi kerak.',
        'file'    => ':attribute fayl hajmi :value kilobaytdan kichik yoki teng bo‘lishi kerak.',
        'numeric' => ':attribute maydoni :value dan kichik yoki teng bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :value dan kichik yoki teng bo‘lishi kerak.',
    ],
    'mac_address'          => 'The :attribute must be a valid MAC address.',
    'max'                  => [
        'array'   => ':attribute ning elementlar soni :max tadan oshmasligi kerak.',
        'file'    => ':attribute dagi faylning hajmi :max kilobaytdan oshmasligi kerak.',
        'numeric' => ':attribute ning qiymati :max dan oshmasligi kerak.',
        'string'  => ':attribute ning belgilar soni :max tadan oshmasligi kerak.',
    ],
    'max_digits'           => 'The :attribute must not have more than :max digits.',
    'mimes'                => ':attribute dagi fayl quyidagi turlardan biri bo‘lishi kerak: :values.',
    'mimetypes'            => ':attribute dagi fayl quyidagi turlardan biri bo‘lishi kerak: :values.',
    'min'                  => [
        'array'   => ':attribute dagi elementlar soni :min tadan kam bo‘lmasligi kerak.',
        'file'    => ':attribute dagi faylning hajmi :min kilobaytdan kam bo‘lmasligi kerak.',
        'numeric' => ':attribute ning qiymati :min dan kam bo‘lmasligi kerak.',
        'string'  => ':attribute dagi belgilar soni :min tadan kam bo‘lmasligi kerak.',
    ],
    'min_digits'           => 'The :attribute must have at least :min digits.',
    'missing'              => 'The :attribute field must be missing.',
    'missing_if'           => 'The :attribute field must be missing when :other is :value.',
    'missing_unless'       => 'The :attribute field must be missing unless :other is :value.',
    'missing_with'         => 'The :attribute field must be missing when :values is present.',
    'missing_with_all'     => 'The :attribute field must be missing when :values are present.',
    'multiple_of'          => ':attribute bir nechta :value bo\'lishi kerak',
    'not_in'               => ':attribute uchun tanlangan qiymat xato.',
    'not_regex'            => ':attribute uchun tanlangan format xato.',
    'numeric'              => ':attribute son bo‘lishi kerak.',
    'password'             => [
        'letters'       => 'The :attribute must contain at least one letter.',
        'mixed'         => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers'       => 'The :attribute must contain at least one number.',
        'symbols'       => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present'              => ':attribute maydoni ko‘rsatilishi kerak.',
    'present_if'           => 'The :attribute field must be present when :other is :value.',
    'present_unless'       => 'The :attribute field must be present unless :other is :value.',
    'present_with'         => 'The :attribute field must be present when :values is present.',
    'present_with_all'     => 'The :attribute field must be present when :values are present.',
    'prohibited'           => ':attribute maydon taqiqlanadi.',
    'prohibited_if'        => ':attribute maydon :other :value bo\'lganda taqiqlanadi.',
    'prohibited_unless'    => ':attribute sohasida ekan taqiqlanadi :other yilda :values.',
    'prohibits'            => 'The :attribute field prohibits :other from being present.',
    'regex'                => ':attribute maydoni xato formatda.',
    'required'             => ':attribute maydoni to‘ldirilishi shart.',
    'required_array_keys'  => 'The :attribute field must contain entries for: :values.',
    'required_if'          => ':other maydoni :value ga teng bo‘lsa, :attribute maydoni to‘ldirilishi shart.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless'      => ':other maydoni :values ga teng bo‘lmasa, :attribute maydoni to‘ldirilishi shart.',
    'required_with'        => ':values ko‘rsatilgan bo‘lsa, :attribute maydoni to‘ldirilishi shart.',
    'required_with_all'    => ':values ko‘rsatilgan bo‘lsa, :attribute maydoni to‘ldirilishi shart.',
    'required_without'     => ':values ko‘rsatilmagan bo‘lsa, :attribute maydoni to‘ldirilishi shart.',
    'required_without_all' => ':values lardan hech biri ko‘rsatilmagan bo‘lsa, :attribute maydoni to‘ldirilishi shart.',
    'same'                 => ':attribute ning qiymati :other bilan bir xil bo‘lishi kerak.',
    'size'                 => [
        'array'   => ':attribute dagi elementlar soni :size ga teng bo‘lishi kerak.',
        'file'    => ':attribute dagi faylning hajmi :size kilobaytga teng bo‘lishi kerak.',
        'numeric' => ':attribute qiymati :size ga teng bo‘lishi kerak.',
        'string'  => ':attribute dagi belgilar soni :size ga teng bo‘lishi kerak.',
    ],
    'starts_with'          => ':attribute quyidagi qiymatlardan biri bilan boshlanishi kerak: :values.',
    'string'               => ':attribute qator bo‘lishi kerak.',
    'timezone'             => ':attribute ning qiymati mavjud vaqt mintaqasi bo‘lishi kerak.',
    'ulid'                 => 'The :attribute must be a valid ULID.',
    'unique'               => ':attribute maydonining bunday qiymati mavjud. Iltimos boshqa qiymat kiriting.',
    'uploaded'             => ':attribute ni yuklash muvaffaqiyatli amalga oshmadi.',
    'uppercase'            => 'The :attribute must be uppercase.',
    'url'                  => ':attribute noto‘g‘ri formatga ega.',
    'uuid'                 => ':attribute to‘g‘ri UUID qiymatga ega bo‘lishi kerak.',
];

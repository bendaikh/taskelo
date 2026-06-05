@props(['text' => '', 'forPdf' => false])

@php
    $isArabic = \App\Support\ArabicText::containsArabic($text);
    $displayText = $forPdf ? \App\Support\ArabicText::forPdf($text) : $text;
@endphp

@if($isArabic)
    <span {{ $attributes->merge(['class' => 'arabic-text', 'dir' => $forPdf ? 'ltr' : 'rtl']) }}>
        {{ $displayText }}
    </span>
@else
    <span {{ $attributes }}>
        {{ $displayText }}
    </span>
@endif

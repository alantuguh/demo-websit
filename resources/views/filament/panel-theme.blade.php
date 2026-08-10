{{-- Tema kaca LPSKE untuk seluruh panel Filament.
     Disisipkan lewat PanelsRenderHook::HEAD_END dari ketiga PanelProvider,
     sehingga selalu dimuat setelah stylesheet bawaan Filament.
     Query ?v= memakai waktu modifikasi file agar cache browser ikut tersegarkan
     setiap kali CSS-nya diubah. --}}
@php
    $lpskePanelCss = public_path('css/lpske-panel.css');
@endphp
<link rel="stylesheet"
      href="{{ asset('css/lpske-panel.css') }}{{ is_file($lpskePanelCss) ? '?v=' . filemtime($lpskePanelCss) : '' }}">

@props(['jenis' => 'logo'])
<div {{ $attributes->merge(['class' => 'relative overflow-hidden bg-[radial-gradient(ellipse_80%_90%_at_90%_0%,rgb(198_146_66/.18),transparent_55%),linear-gradient(140deg,#0f1c3f,#0b1426)]']) }} aria-hidden="true">
    <svg viewBox="0 0 400 260" class="absolute inset-0 size-full" preserveAspectRatio="xMidYMid slice" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="titik-{{ $jenis }}" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1" fill="#fff" fill-opacity=".08" /></pattern>
        </defs>
        <rect width="400" height="260" fill="url(#titik-{{ $jenis }})" />

        @if ($jenis === 'logo')
            <rect x="105" y="35" width="190" height="170" rx="22" fill="#fff" fill-opacity=".08" stroke="#fff" stroke-opacity=".2" />
            <circle cx="200" cy="100" r="36" fill="#d2f824" />
            <path d="M200 64a36 36 0 0 0 0 72Z" fill="#1f423b" />
            <rect x="150" y="152" width="100" height="10" rx="5" fill="#fff" fill-opacity=".85" />
            <rect x="168" y="172" width="64" height="6" rx="3" fill="#fff" fill-opacity=".3" />
            <circle cx="160" cy="232" r="9" fill="#d2f824" /><circle cx="186" cy="232" r="9" fill="#1f423b" stroke="#fff" stroke-opacity=".3" />
            <circle cx="212" cy="232" r="9" fill="#fff" /><circle cx="238" cy="232" r="9" fill="#8e9e98" />
        @elseif ($jenis === 'kaos')
            <path d="M150 48 180 36q20 22 40 0l30 12 50 40-28 30-20-16v124H148V102l-20 16-28-30Z" fill="#1f423b" stroke="#fff" stroke-opacity=".25" stroke-width="1.5" />
            <path d="M180 36q20 22 40 0" stroke="#fff" stroke-opacity=".3" stroke-width="2" />
            <circle cx="200" cy="120" r="24" fill="#d2f824" />
            <path d="M188 120h24M200 108v24" stroke="#0d1b18" stroke-width="5" stroke-linecap="round" />
            <rect x="170" y="158" width="60" height="7" rx="3.5" fill="#fff" fill-opacity=".7" />
            <rect x="180" y="172" width="40" height="5" rx="2.5" fill="#fff" fill-opacity=".3" />
        @elseif ($jenis === 'video')
            <rect x="50" y="34" width="300" height="180" rx="18" fill="#0d1b18" stroke="#fff" stroke-opacity=".22" />
            <rect x="50" y="34" width="300" height="180" rx="18" fill="url(#glow-{{ $jenis }})" />
            <circle cx="200" cy="112" r="30" fill="#d2f824" />
            <path d="M192 98v28l24-14Z" fill="#0d1b18" />
            <rect x="72" y="188" width="256" height="6" rx="3" fill="#fff" fill-opacity=".18" />
            <rect x="72" y="188" width="118" height="6" rx="3" fill="#d2f824" />
            <circle cx="190" cy="191" r="6" fill="#fff" />
            <rect x="72" y="52" width="46" height="14" rx="7" fill="#d2f824" fill-opacity=".9" />
            <defs><radialGradient id="glow-{{ $jenis }}" cx=".8" cy=".1" r=".9"><stop stop-color="#1f423b" stop-opacity=".8" /><stop offset="1" stop-color="#0d1b18" stop-opacity="0" /></radialGradient></defs>
        @elseif ($jenis === 'foto')
            <rect x="80" y="36" width="240" height="180" rx="14" fill="#fff" fill-opacity=".05" stroke="#fff" stroke-opacity=".2" />
            <circle cx="262" cy="88" r="16" fill="#d2f824" />
            <path d="M80 190l82-76 48 50 36-30 74 56v26H80Z" fill="#1f423b" />
            <path d="M80 190l82-76 24 25-52 51Z" fill="#fff" fill-opacity=".08" />
            <path d="M96 62V48h14M304 62V48h-14M96 190v14h14M304 190v14h-14" stroke="#d2f824" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <rect x="184" y="108" width="32" height="32" rx="4" stroke="#d2f824" stroke-width="2" stroke-dasharray="5 4" />
        @elseif ($jenis === 'poster')
            <rect x="118" y="34" width="120" height="196" rx="10" fill="#1f423b" stroke="#fff" stroke-opacity=".22" transform="rotate(-8 178 132)" />
            <rect x="152" y="22" width="130" height="212" rx="10" fill="#d2f824" />
            <rect x="168" y="42" width="84" height="14" rx="4" fill="#0d1b18" />
            <rect x="168" y="62" width="58" height="14" rx="4" fill="#0d1b18" />
            <circle cx="217" cy="136" r="32" fill="#0d1b18" />
            <path d="M217 112a24 24 0 0 1 0 48Z" fill="#d2f824" />
            <rect x="168" y="188" width="96" height="5" rx="2.5" fill="#0d1b18" fill-opacity=".6" />
            <rect x="168" y="200" width="70" height="5" rx="2.5" fill="#0d1b18" fill-opacity=".4" />
        @elseif ($jenis === 'banner')
            <path d="M92 168v54M308 168v54" stroke="#fff" stroke-opacity=".3" stroke-width="4" stroke-linecap="round" />
            <rect x="40" y="62" width="320" height="108" rx="12" fill="#1f423b" stroke="#fff" stroke-opacity=".25" />
            <circle cx="104" cy="116" r="30" fill="#d2f824" />
            <path d="M92 116h24m-10-10 10 10-10 10" stroke="#0d1b18" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            <rect x="152" y="94" width="150" height="14" rx="5" fill="#fff" />
            <rect x="152" y="116" width="110" height="9" rx="4.5" fill="#fff" fill-opacity=".45" />
            <rect x="152" y="136" width="64" height="16" rx="8" fill="#d2f824" />
        @elseif ($jenis === 'flyer')
            <rect x="62" y="44" width="84" height="172" rx="8" fill="#fff" fill-opacity=".1" stroke="#fff" stroke-opacity=".22" />
            <rect x="158" y="44" width="84" height="172" rx="8" fill="#d2f824" />
            <rect x="254" y="44" width="84" height="172" rx="8" fill="#1f423b" stroke="#fff" stroke-opacity=".22" />
            <circle cx="104" cy="92" r="18" fill="#d2f824" /><rect x="76" y="128" width="56" height="6" rx="3" fill="#fff" fill-opacity=".7" /><rect x="76" y="142" width="40" height="5" rx="2.5" fill="#fff" fill-opacity=".3" />
            <rect x="172" y="66" width="56" height="12" rx="4" fill="#0d1b18" /><rect x="172" y="88" width="42" height="12" rx="4" fill="#0d1b18" /><rect x="172" y="170" width="56" height="22" rx="11" fill="#0d1b18" />
            <rect x="268" y="66" width="56" height="6" rx="3" fill="#fff" fill-opacity=".7" /><rect x="268" y="80" width="40" height="6" rx="3" fill="#fff" fill-opacity=".4" /><rect x="268" y="150" width="56" height="42" rx="6" fill="#d2f824" fill-opacity=".9" />
        @endif
    </svg>
    {{ $slot }}
</div>
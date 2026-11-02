<svg viewBox="0 0 80 80" fill="none" stroke="currentColor" stroke-width="1.4" focusable="false">
    @if($slug === 'pengetahuan-umum')
        <circle cx="40" cy="40" r="29"/><ellipse cx="40" cy="40" rx="13" ry="29"/>
        <path d="M11 40h58M16 24h48M16 56h48"/>
    @elseif($slug === 'teknologi')
        <rect x="20" y="20" width="40" height="40" rx="3"/><rect x="30" y="30" width="20" height="20"/>
        <path d="M30 10v10M40 10v10M50 10v10M30 60v10M40 60v10M50 60v10M10 30h10M10 40h10M10 50h10M60 30h10M60 40h10M60 50h10"/>
    @else
        <ellipse cx="40" cy="40" rx="32" ry="12"/><ellipse cx="40" cy="40" rx="32" ry="12" transform="rotate(60 40 40)"/>
        <ellipse cx="40" cy="40" rx="32" ry="12" transform="rotate(120 40 40)"/><circle cx="40" cy="40" r="3" fill="currentColor"/>
    @endif
</svg>

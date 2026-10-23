<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SitterControl</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Script imediato para evitar flash de tela clara se tema escuro estiver ativo -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('sitter_theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            } catch (e) {}
        })();
    </script>
</head>

<body>

    <!-- ICON SPRITE -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <g id="ic-base" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></g>
        </defs>
        <symbol id="i-sprout" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22v-7" />
                <path d="M12 15c-4.2 0-7.5-3.2-7.5-7.3C8.7 7.7 12 9.6 12 15z" />
                <path d="M12 12.3c0-3.4 2.9-7.3 7-7.3.3 4.3-1.1 7.3-4.2 7.3" />
            </g>
        </symbol>
        <symbol id="i-grid" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3.3" y="3.3" width="7.2" height="7.2" rx="1.6" />
                <rect x="13.5" y="3.3" width="7.2" height="7.2" rx="1.6" />
                <rect x="3.3" y="13.5" width="7.2" height="7.2" rx="1.6" />
                <rect x="13.5" y="13.5" width="7.2" height="7.2" rx="1.6" />
            </g>
        </symbol>
        <symbol id="i-smile" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M8.6 10.6h.01M15.4 10.6h.01" />
                <path d="M8.2 14.3c1 1.6 2.4 2.4 3.8 2.4s2.8-.8 3.8-2.4" />
            </g>
        </symbol>
        <symbol id="i-users" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="8" r="3.1" />
                <path d="M3.6 20c0-3.3 2.4-5.7 5.6-5.7s5.6 2.4 5.6 5.7" />
                <circle cx="17.3" cy="9" r="2.5" />
                <path d="M15.7 14.5c2.5.4 4.3 2.4 4.3 5.5" />
            </g>
        </symbol>
        <symbol id="i-check-square" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3.6" y="3.6" width="16.8" height="16.8" rx="3.2" />
                <path d="M8 12.4l2.6 2.6L16.4 9" />
            </g>
        </symbol>
        <symbol id="i-wallet" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3.6 7.6a2 2 0 012-2h11a2 2 0 012 2v8.8a2 2 0 01-2 2h-11a2 2 0 01-2-2z" />
                <path d="M15.8 12.3h3.4v3h-3.4a1.5 1.5 0 010-3z" />
            </g>
        </symbol>
        <symbol id="i-user-circle" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <circle cx="12" cy="10.2" r="3" />
                <path d="M6.4 18.2c.9-2.5 3.1-4 5.6-4s4.7 1.5 5.6 4" />
            </g>
        </symbol>
        <symbol id="i-logout" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9.5 4.2H6.3a2 2 0 00-2 2v11.6a2 2 0 002 2h3.2" />
                <path d="M15.2 16l4-4-4-4" />
                <path d="M19 12H9.2" />
            </g>
        </symbol>
        <symbol id="i-search" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.5" cy="10.5" r="6.3" />
                <path d="M19.8 19.8l-4.4-4.4" />
            </g>
        </symbol>
        <symbol id="i-bell" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6.2 10a5.8 5.8 0 0111.6 0c0 3.8 1.4 5.2 1.4 5.2H4.8S6.2 13.8 6.2 10z" />
                <path d="M10.5 18.3a1.6 1.6 0 003 0" />
            </g>
        </symbol>
        <symbol id="i-plus" viewBox="0 0 24 24">
            <g fill="none" stroke-width="2" stroke-linecap="round">
                <path d="M12 5v14M5 12h14" />
            </g>
        </symbol>
        <symbol id="i-pencil" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4.2 17.4l-.4 2.8 2.8-.4L18.7 7.7l-2.4-2.4z" />
                <path d="M14.5 6.1l2.4 2.4" />
            </g>
        </symbol>
        <symbol id="i-trash" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4.5 7h15" />
                <path d="M9.2 7V5.2a1 1 0 011-1h3.6a1 1 0 011 1V7" />
                <path d="M6.6 7l.9 12a2 2 0 002 2h5a2 2 0 002-2l.9-12" />
            </g>
        </symbol>
        <symbol id="i-x" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.9" stroke-linecap="round">
                <path d="M6 6l12 12M18 6L6 18" />
            </g>
        </symbol>
        <symbol id="i-calendar" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3.6" y="5" width="16.8" height="15" rx="2.2" />
                <path d="M3.6 9.6h16.8" />
                <path d="M8 3v4M16 3v4" />
            </g>
        </symbol>
        <symbol id="i-mail" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3.6" y="5.6" width="16.8" height="12.8" rx="2" />
                <path d="M4.4 6.6l7.6 6 7.6-6" />
            </g>
        </symbol>
        <symbol id="i-phone" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8.3 4.6c-2 0-3.6 1.5-3.2 3.6.6 3.8 2.6 7.3 5.7 9.5 2 1.4 5.4 1.9 6.4-.1l.9-1.9-3.9-2.5-.9 1.4c-1.8-1-3.2-2.5-4.2-4.3l1.4-1-2.4-3.9-.8-.8z" />
            </g>
        </symbol>
        <symbol id="i-alert" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4L2.4 20h19.2z" />
                <path d="M12 10.2v3.8" />
                <path d="M12 16.8h.01" />
            </g>
        </symbol>
        <symbol id="i-star" viewBox="0 0 24 24">
            <path d="M12 3.4l2.5 5 5.6.7-4.1 3.8 1 5.5-5-2.6-5 2.6 1-5.5-4.1-3.8 5.6-.7z" stroke-width="1.6" stroke-linejoin="round" />
        </symbol>
        <symbol id="i-check" viewBox="0 0 24 24">
            <g fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 12.5l5 5L20 6" />
            </g>
        </symbol>
        <symbol id="i-clock" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7.2v5l3.4 2" />
            </g>
        </symbol>
        <symbol id="i-menu" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.9" stroke-linecap="round">
                <path d="M4 6.5h16M4 12h16M4 17.5h16" />
            </g>
        </symbol>
        <symbol id="i-moon" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </g>
        </symbol>
        <symbol id="i-sun" viewBox="0 0 24 24">
            <g fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5" />
                <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
            </g>
        </symbol>
    </svg>

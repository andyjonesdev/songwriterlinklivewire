<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ isset($title) ? $title . ' — SongwriterLink' : 'SongwriterLink' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] },
                colors: {
                    brand: {
                        DEFAULT: '#7c3aed',
                        dark:    '#6d28d9',
                        light:   '#a78bfa',
                    },
                },
            },
        },
    }
</script>

@fluxAppearance

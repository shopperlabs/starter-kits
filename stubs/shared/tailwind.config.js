import colors from 'tailwindcss/colors';
import defaultTheme from 'tailwindcss/defaultTheme';
import aspectRatio from '@tailwindcss/aspect-ratio';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import preset from './vendor/filament/support/tailwind.config.preset';

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  content: [
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './vendor/laravelcm/livewire-slide-overs/resources/views/*.blade.php',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  safelist: [
    {
      pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
      variants: ['sm', 'md', 'lg', 'xl', '2xl']
    }
  ],
  theme: {
    extend: {
      animation: {
        blink: 'blink 1.4s both infinite',
      },
      keyframes: {
        blink: {
          '0%': { opacity: 0.2 },
          '20%': { opacity: 1 },
          '100% ': { opacity: 0.2 },
        },
      },
      colors: {
        primary: colors.teal,
      },
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        heading: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
      },
      maxWidth: {
        '8xl': '98rem',
      }
    },
  },
  plugins: [aspectRatio, forms, typography],
};

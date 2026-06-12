import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                'display-lg-mobile': ['"Plus Jakarta Sans"'],
                'title-lg': ['"Plus Jakarta Sans"'],
                'body-lg': ['"Plus Jakarta Sans"'],
                'label-md': ['"Plus Jakarta Sans"'],
                'headline-md-mobile': ['"Plus Jakarta Sans"'],
                'body-md': ['"Plus Jakarta Sans"'],
                'display-lg': ['"Plus Jakarta Sans"'],
                'headline-md': ['"Plus Jakarta Sans"']
            },
            fontSize: {
                'display-lg-mobile': ["36px", {"lineHeight": "1.2", "fontWeight": "800"}],
                'title-lg': ["22px", {"lineHeight": "1.5", "fontWeight": "600"}],
                'body-lg': ["18px", {"lineHeight": "1.8", "fontWeight": "400"}],
                'label-md': ["14px", {"lineHeight": "1.4", "letterSpacing": "0.02em", "fontWeight": "600"}],
                'headline-md-mobile': ["28px", {"lineHeight": "1.3", "fontWeight": "700"}],
                'body-md': ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                'display-lg': ["56px", {"lineHeight": "1.1", "letterSpacing": "-0.03em", "fontWeight": "800"}],
                'headline-md': ["40px", {"lineHeight": "1.2", "fontWeight": "700"}]
            },
            colors: {
                primary: '#630ed4',
                'primary-fixed-dim': '#d2bbff',
                'inverse-primary': '#d2bbff',
                'on-primary-fixed-variant': '#5a00c6',
                surface: '#fef7ff',
                'secondary-fixed': '#f0dbff',
                'on-surface': '#1d1a24',
                'tertiary-container': '#bf2076',
                'on-secondary-container': '#fffbff',
                'surface-container-highest': '#e8dfee',
                tertiary: '#9b005c',
                'primary-container': '#7c3aed',
                'on-tertiary-fixed-variant': '#8c0053',
                'surface-container-low': '#f9f1ff',
                'surface-container': '#f3ebfa',
                'error-container': '#ffdad6',
                'tertiary-fixed': '#ffd9e4',
                'surface-tint': '#732ee4',
                'on-error': '#ffffff',
                'on-tertiary': '#ffffff',
                'surface-container-lowest': '#ffffff',
                'surface-container-high': '#ede5f4',
                'surface-bright': '#fef7ff',
                background: '#fef7ff',
                'tertiary-fixed-dim': '#ffb0cd',
                'on-secondary-fixed': '#2c0051',
                'surface-variant': '#e8dfee',
                'secondary-fixed-dim': '#ddb7ff',
                'on-secondary': '#ffffff',
                error: '#ba1a1a',
                'surface-dim': '#dfd7e6',
                'inverse-surface': '#332f39',
                secondary: '#8127cf',
                outline: '#7b7487',
                'on-surface-variant': '#4a4455',
                'secondary-container': '#9c48ea',
                'on-tertiary-fixed': '#3e0022',
                'on-primary': '#ffffff',
                'outline-variant': '#ccc3d8',
                'primary-fixed': '#eaddff',
                'on-secondary-fixed-variant': '#6900b3',
                'on-tertiary-container': '#ffdde7',
                'on-background': '#1d1a24',
                'on-primary-container': '#ede0ff',
                'on-error-container': '#93000a',
                'inverse-on-surface': '#f6eefc',
                'on-primary-fixed': '#25005a',
            },
            spacing: {
                'section-gap': '100px',
                'gutter': '24px',
                'margin-desktop': '48px',
                'margin-mobile': '16px',
                'container-max': '1280px',
            },
            borderRadius: {
                'card': '24px',
            },
            boxShadow: {
                'glow': '0 8px 20px rgba(124, 58, 237, 0.04)',
                'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
            }
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/container-queries')
    ],
};

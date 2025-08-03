import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './diepxuan/*/resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography,
        plugin(function ({ addVariant, e, postcss }) {
            addVariant("print", ({ container, separator }) => {
                const rule = postcss.atRule({ name: "media", params: "print" });
                rule.append(container.nodes);
                container.append(rule);
                rule.walkRules((r) => {
                    r.selector = `.${e(`print${separator}${r.selector.slice(1)}`)}`;
                });
            });
        }),
    ],
};

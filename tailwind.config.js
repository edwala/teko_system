const colors = require('tailwindcss/colors')

module.exports = {
  content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
      './vendor/filament/**/*.blade.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        colors: {
            colors: {
                danger: colors.rose,
                primary: {
                    50: "#1E55B3",
                    100: "#1E55B3",
                    200: "rgba(30,85,179,0.9)",
                    300: "rgba(30,85,179,0.9)",
                    400: "rgba(30,85,179,0.75)",
                    500: "rgba(30,85,179,0.85)",
                    600: "rgba(30,85,179,0.95)",
                    700: "rgba(30,85,179,0.9)",
                    800: "rgba(30,85,179,0.9)",
                    900: "rgba(30,85,179,0.9)",
                },
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
  ],
}

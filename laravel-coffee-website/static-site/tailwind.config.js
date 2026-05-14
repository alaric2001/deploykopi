/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './*.html',
    './admin/**/*.html',
    './src/**/*.{js,html}'
  ],
  theme: {
    extend: {
      colors: {
        primary: '#FFE5B6',
        primary_hover: '#dcc69e',
        secondary: '#3d372b',
        secondary_hover: '#25211a'
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif']
      }
    }
  },
  plugins: []
};

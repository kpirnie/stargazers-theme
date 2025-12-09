/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './templates/**/*.php',
    './assets/js/**/*.js',
  ],
  safelist: [
    {
      pattern: /^(mt|mb|pt|pb|px|py|mx|my)-/,  // All margin/padding classes
    },
    {
      pattern: /^text-(left|center|right|justify)/,  // Text alignment
    },
    {
      pattern: /^bg-(slate|cyan|gray)-/,  // Background colors
    },
    {
      pattern: /^border(-slate|-cyan|-gray)?-?/,  // Borders
    },
    {
      pattern: /^rounded(-lg|-xl)?/,  // Rounded corners
    },
  ],
  theme: {
    extend: {
      colors: {
        // Custom astronomy colors from the logo
        'astro-dark': '#0e3759',
        'astro-mid': '#185e98',
        'astro-light': '#77aad4',
      },
      fontFamily: {
        'heading': ['Orbitron', 'sans-serif'],
        'body': ['Raleway', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

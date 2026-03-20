import type { Config } from 'tailwindcss'

export default {
  content: ['./index.html', './src/**/*.{vue,ts}'],
  theme: {
    extend: {
      colors: {
        brand: {
          ink: '#0f172a',
          teal: '#0f766e',
          sand: '#f59e0b',
          mist: '#e2e8f0',
        },
      },
      boxShadow: {
        none: 'none',
      },
      padding: {
        safe: 'max(1rem, env(safe-area-inset-bottom))',
      },
    },
  },
  plugins: [],
} satisfies Config

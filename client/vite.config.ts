/// <reference types="vitest" />
import path from 'path'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import unfonts from 'unplugin-fonts/vite'
import checker from 'vite-plugin-checker'
import eslint from 'vite-plugin-eslint'

// https://vitejs.dev/config/
export default defineConfig(({ mode }) => ({
  ...(mode !== 'test' && {
    plugins: [
      react(),
      eslint(),
      checker({ typescript: true }),
      unfonts({
        google: {
          families: [
            { name: 'Titillium+Web', styles: 'wght@700' },
            { name: 'Source+Serif+Pro', styles: 'wght@400;700' },
            { name: 'Merriweather+Sans', styles: 'wght@400;700' },
            {
              name: 'Source+Sans+Pro',
              styles:
                'ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700',
            },
          ],
        },
      }),
    ],
  }),
  test: {
    environment: 'jsdom',
    setupFiles: 'src/6shared/lib/test/setup.ts',
    coverage: {
      provider: 'v8',
      exclude: ['src/6shared/api/realworld/**'],
    },
  },
  server: { host: false },
  preview: { open: true },
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          'article-service': [
            'src/6shared/api/article/article.service.ts',
            'src/6shared/api/article/index.ts',
          ],
          'auth-service': [
            'src/6shared/api/auth/auth.service.ts',
            'src/6shared/api/auth/index.ts',
          ],
          'comment-service': [
            'src/6shared/api/comment/comment.service.ts',
            'src/6shared/api/comment/index.ts',
          ],
          'favorite-service': [
            'src/6shared/api/favorite/favorite.service.ts',
            'src/6shared/api/favorite/index.ts',
          ],
          'profile-service': [
            'src/6shared/api/profile/profile.service.ts',
            'src/6shared/api/profile/index.ts',
          ],
          'tag-service': [
            'src/6shared/api/tag/tag.service.ts',
            'src/6shared/api/tag/index.ts',
          ],
        },
      },
    },
  },
  resolve: {
    alias: {
      '~1app': path.resolve('src/1app'),
      '~2pages': path.resolve('src/2pages'),
      '~3widgets': path.resolve('src/3widgets'),
      '~4features': path.resolve('src/4features'),
      '~5entities': path.resolve('src/5entities'),
      '~6shared': path.resolve('src/6shared'),
    },
  },
}))

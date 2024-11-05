// .eslintrc.js
module.exports = {
    env: {
    browser: true,
    es2021: true,
  },
  plugins: ['import', 'react-refresh'],
    parserOptions: {
    ecmaVersion: 12,
    sourceType: 'module',
  },
    extends: [
    'eslint:recommended',
    'plugin:react/recommended',
    'plugin:react-hooks/recommended',
    'airbnb',
    'prettier',
    'plugin:eslint-plugin-import/recommended',

    // Outras extensões conforme necessário
  ],
    ignorePatterns: [
    'node_modules',
    'dist',
    '.eslintrc.cjs',
    'vite-env.d.ts',
    'vite.config.ts',
  ],
  rules: {
       'react/require-default-props': 'off',
        '@typescript-eslint/no-use-before-define': 'off',
        '@typescript-eslint/no-throw-literal': 'off',
        '@typescript-eslint/no-explicit-any': 'off',
    'import/no-restricted-paths': [
      
      'error',
      {
        zones: [
          {
            target: './src/client/**/*',
            from: './src/application/**/*',
            message: 'Client não pode depender da camada de Application'
          },
          {
            target: './src/client/**/*',
            from: './src/infrastructure/**/*',
            message: 'Client não pode depender da camada de Infrastructure'
          },
          {
            target: './src/client/**/*',
            from: './src/presentation/**/*',
            message: 'Client não pode depender da camada de Presentation'
          },
          {
            target: './src/application/**/*',
            from: './src/infrastructure/**/*',
            message: 'Application não pode depender de Infrastructure'
          },
          {
            target: './src/application/**/*',
            from: './src/presentation/**/*',
            message: 'Application não pode depender de Presentation'
          },
          {
            target: './src/infrastructure/**/*',
            from: './src/presentation/**/*',
            message: 'Infrastructure não pode depender de Presentation'
          }
        ]
      }
    ],
    'import/no-cycle': 'error',
    'import/no-self-import': 'error',
    'import/no-useless-path-segments': 'error'
  },
  settings: {
    'import/resolver': {
      node: {
        extensions: ['.js', '.jsx', '.ts', '.tsx']
      }
    }
  }
};
import globals from 'globals'
import js from '@eslint/js'
import pluginTs from 'typescript-eslint'
import pluginVue from 'eslint-plugin-vue'
import configPrettier from 'eslint-config-prettier'
import tsParser from '@typescript-eslint/parser'
import vueParser from 'vue-eslint-parser'

export default [
    js.configs.recommended,
    ...pluginTs.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    configPrettier,

    {
        languageOptions: {
          globals: {
            ...globals.browser,
          },
          ecmaVersion: 2024,
          parserOptions: {
            ecmaFeatures: { jsx: true },
          },
        },

        rules: {
          'arrow-body-style': ['error', 'as-needed'],
          'prefer-arrow-callback': ['error', { allowNamedFunctions: true }],
        },
    },

    {
        files: ['service/**/*.js', '.prettierrc.js', '.stylelintrc.js', 'babel.config.js'],

        languageOptions: {
          globals: {
            ...globals.node,
          },
        },

        rules: {
          '@typescript-eslint/no-var-requires': 'off',
          '@typescript-eslint/no-require-imports': 'off',
        },
    },

    {
        files: ['**/*.ts', '**/*.tsx'],
        languageOptions: {
            parser: tsParser, // ✅ импортированный модуль
            parserOptions: {
                ecmaVersion: 2024,
                sourceType: 'module',
            },
        },
        rules: {
            // твои TS-правила
        },
    },
    {
        files: ['**/*.vue'],
        languageOptions: {
            parser: vueParser, // ✅ импортированный модуль
            parserOptions: {
                parser: tsParser, // ✅ для <script lang="ts">
                ecmaVersion: 2024,
                sourceType: 'module',
            },
        },
    },

  {
    ignores: ['dist'],
  },
]

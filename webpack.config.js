const { mix } = require('laravel-mix');
const path = require('path');
const root = path.resolve(__dirname);


/*
 |--------------------------------------------------------------------------
 | Extended Mix Configuration
 |--------------------------------------------------------------------------
 |
 | Here we define our custom Configuration.
 |
 */

mix.webpackConfig({
  resolve: {
    alias: {
      '@root': `${root}/resources/assets/js`,
      '@common': `${root}/resources/assets/js/components/common`,
      '@component': `${root}/resources/assets/js/components`
    }
  }
});

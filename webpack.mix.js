// webpack.mix.js
const CKEditorWebpackPlugin = require('@ckeditor/ckeditor5-dev-webpack-plugin');
const { styles } = require('@ckeditor/ckeditor5-dev-utils');
const CKERegex = {
    svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
    css: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/,
};

let mix = require('laravel-mix');
Mix.listen('configReady', webpackConfig => {
    const rules = webpackConfig.module.rules;

    // these change often! Make sure you copy the correct regexes for your Webpack version!
    const targetSVG = /(\.(png|jpe?g|gif|webp|avif)$|^((?!font).)*\.svg$)/;
    const targetFont = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/;
    const targetCSS = /\.p?css$/;

    // exclude CKE regex from mix's default rules
    for (let rule of rules) {
      // console.log(rule.test) // uncomment to check the CURRENT rules

      if (rule.test.toString() === targetSVG.toString()) {
        rule.exclude = CKERegex.svg;
      } else if (rule.test.toString() === targetFont.toString()) {
        rule.exclude = CKERegex.svg;
      } else if (rule.test.toString() === targetCSS.toString()) {
        rule.exclude = CKERegex.css;
      }
    }
  });
mix.webpackConfig({
    plugins: [
        new CKEditorWebpackPlugin({
            language: 'en',
            addMainLanguageTranslationsToAllAssets: true
        })
    ],
    module: {
        rules: [
            {
                test: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,

                use: [ 'raw-loader' ]
            },
            {
                test: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/,

                use: [
                    {
                        loader: 'style-loader',
                        options: {
                            injectType: 'singletonStyleTag',
                            attributes: {
                                'data-cke': true
                            }
                        }
                    },
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: styles.getPostCssConfig( {
                                themeImporter: {
                                    themePath: require.resolve( '@ckeditor/ckeditor5-theme-lark' )
                                },
                                minify: true
                            } )
                        }
                    }
                ]
            }
        ]
    }
});
mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/textfieldeditor.js', 'public/js');

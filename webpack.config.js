const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const TsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin');
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const jsonImporter = require('node-sass-json-importer');

const { WEBPACK_ENV } = process.env;

const THEME_NAME = path.basename(process.cwd());
const BUILD_DIR = path.resolve(__dirname, 'build');
const MODE = WEBPACK_ENV === 'development' ? 'development' : 'production';
const DEVTOOL = WEBPACK_ENV === 'development' ? 'cheap-module-source-map' : 'source-map';
const FILE_NAMING_PATTERN = '[name].[ext]';

module.exports = {
    mode: MODE,
    devtool: DEVTOOL,
    entry: {
        tabs: [
            './src/blocks/tabs/tabs.tsx',
            './src/blocks/tabs/tabs.scss',
        ],
        tab: [
            './src/blocks/tab/tab.tsx',
            './src/blocks/tab/tab.scss',
        ],
        main: [
            'core-js/stable',
            './src/main.ts',
            './src/main.scss',
        ],
        admin: [
            './src/admin.scss',
        ]
    },
    output: {
        filename: FILE_NAMING_PATTERN.replace('[ext]', 'js'),
        path: path.resolve(BUILD_DIR, 'static'),
        publicPath: `/wp-content/themes/${THEME_NAME}/build/static/`,
    },
    optimization: {
        minimize: WEBPACK_ENV === 'development' ? false : true,
        minimizer: [new TerserPlugin()],
    },
    plugins: [
        new DependencyExtractionWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: FILE_NAMING_PATTERN.replace('[ext]', 'css'),
            chunkFilename: FILE_NAMING_PATTERN.replace('[ext]', 'css').replace('[name]', '[id]'),
        }),
        new CopyPlugin([
            { from: 'assets', to: '../assets', context: 'src' },
            { from: 'blocks/*.php', to: '../', context: 'src' },
            { from: 'classes', to: '../classes', context: 'src' },
            { from: 'template-parts', to: '../template-parts', context: 'src' },
            { from: 'templates', to: '../templates', context: 'src' },
            { from: '*.php', to: '../.', context: 'src' },
            { from: 'theme.json', to: '../.', context: 'src' },
            { from: 'screenshot.png', to: '../.', context: 'src' },
            { from: '_style.css', to: '../style.css', context: 'src' },
        ]),
    ],
    resolve: {
        extensions: ['.tsx', '.ts', '.js', '.css', '.scss'],
        plugins: [
            new TsconfigPathsPlugin({
                configFile: path.resolve(__dirname, 'tsconfig.json'),
            })
        ],
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: [
                    {
                        loader: 'babel-loader',
                    },
                    {
                        loader: 'ts-loader'
                    }
                ],
                exclude: /node_modules/,
            },
            {
                test: /\.jsx?$/,
                exclude: /(node_modules)/,
                use: [
                    'babel-loader',
                ]
            },
            {
                test: /\.scss/,
                enforce: 'pre',
                loader: 'import-glob-loader'
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            sassOptions: {
                                importer: jsonImporter(),
                            }
                        }
                    }
                ]
            },
            {
                test: /\.(png|jpg|gif|ttf|eot|woff|woff2|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                        },
                    }
                ]
            },
        ]
    },
};

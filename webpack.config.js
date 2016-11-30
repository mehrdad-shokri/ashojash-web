const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const validate = require('webpack-validator');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');
const merge = require('webpack-merge');
const parts = require(path.join(__dirname, 'resources/assets/js/src/libs/parts'));

const PATHS = {
		admin: path.join(__dirname, 'resources/assets/js/src/entries/admin.js'),
		assetsOutput: path.join(__dirname, 'public/build'),
		prodFile: path.join(__dirname, 'resources/views/admin/build'),
		statics: path.join(__dirname, 'resources/assets/statics'),
		styles: path.join(__dirname, 'resources/assets/sass/components'),
		shared: path.join(__dirname, 'resources/assets/sass/shared'),
		node: path.join(__dirname, 'node_modules'),
		images: path.join(__dirname, 'resources/assets/statics/img'),
		fonts: path.join(__dirname, 'resources/assets/statics/font')
};
const common = {
		resolve: {
				extensions: ['', '.js', '.jsx']
		}
};

const commonWithLoaders = merge(common, parts.babel(PATHS.app), parts.setupFonts([PATHS.fonts, PATHS.node]));
var config;
switch (process.env.npm_lifecycle_event) {
		case 'build':
		case 'stats':
				config = merge(
						commonWithLoaders,
						parts.purifyCSS([PATHS.admin]),
						{
								entry: {
										admin: PATHS.admin,
								}
						},
						parts.extractBundle({
								name: 'vendor',
								entries: ['react', 'react-router', 'redux', 'react-redux', 'axios', 'react-dom', 'redux-promise', 'redux-form']
						}),
						{
								devtool: 'source-map'
						},
						parts.clean([PATHS.prodFile, PATHS.assetsOutput]),
						{
								output: {
										path: PATHS.assetsOutput,
										filename: '[name].[chunkhash].js',
										chunkFilename: '[chunkhash].js',
										publicPath: '/build/'
								}
						},
						parts.setFreeVariable(
								'process.env.NODE_ENV',
								'production'
						),
						parts.setupFile(PATHS.images),
						parts.extractText(PATHS.styles, [PATHS.shared, PATHS.node]),
						parts.minify(),
						{
								plugins: [
										new HtmlWebpackPlugin({
												title: 'آشوجاش| پنل مدریت',
												inject: false,
												filename: PATHS.prodFile + '/index.blade.php',
												template: require('html-webpack-template'),
												appMountId: 'appContainer',
												mobile: true,
												meta:{
														'theme-color':'#FF5A64',
														'msapplication-navbutton-color':'#FF5A64',
														'apple-mobile-web-app-status-bar-style':'#FF5A64'
												}
										}),
										new FaviconsWebpackPlugin(PATHS.statics + '\\ashojash.png')
								]
						}
				);
				break;
		default:
				config = merge(
						commonWithLoaders,
						{
								entry: {
										admin: [
												'webpack-dev-server/client?http://0.0.0.0:3000',
												'webpack/hot/only-dev-server',
												PATHS.admin,
										]
								}
						},
						{
								output: {
										path: PATHS.assetsOutput,
										filename: '[name].js',
										publicPath: '/' //used for require.ensure. The setup
								}
						},
						parts.setupSass(PATHS.styles, [PATHS.shared, PATHS.node]),
						parts.setupUrl(PATHS.images),
						parts.reactHot(),
						{
								plugins: [
										new HtmlWebpackPlugin({
												title: 'آشوجاش| پنل مدریت',
												inject: false,
												filename: 'index.html',
												template: require('html-webpack-template'),
												appMountId: 'appContainer',
												meta: {
														'theme-color':'#FF5A64',
														'msapplication-navbutton-color':'#FF5A64',
														'apple-mobile-web-app-status-bar-style':'#FF5A64'
												},
												mobile: true,
										}),
								]
						}
				);
}
module.exports = validate(config, {
		quiet: true
});
const webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const PurifyCSSPlugin = require('purifycss-webpack-plugin');
exports.setupSass = function(paths, shared) {
		return {
				module: {
						loaders: [
								{
										test: /\.(scss|css)$/,
										loaders: ['style', 'css?modules&sourceMap', 'sass?outputStyle=expanded&sourceMap'],
										include: paths,
										exclude: shared,
								},
								{
										test: /\.(scss|css)$/,
										loaders: ['style', 'css', 'sass'],
										include: shared
								}
						]
				}
		};
}
exports.extractText = function(paths, shared) {
		return {

				module: {
						loaders: [
								{
										test: /\.(scss|css)$/,
										loader: ExtractTextPlugin.extract('style', 'css?modules!sass?outputStyle=expanded'),
										include: paths,
										exclude: shared
								},
								{
										test: /\.(scss|css)$/,
										loader: ExtractTextPlugin.extract('style', 'css?!sass?outputStyle=expanded'),
										include: shared
								}
						]
				},
				plugins: [
						new ExtractTextPlugin('[name].[chunkhash].css', {
								allChunks: true
						})
				]
		};
}
exports.babel = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.(js|jsx)$/,
										include: path,
										loader: 'babel',
										exclude: /node_modules/,
										query: {
												presets: ['react', 'es2015', 'stage-1']
										}
								}
						]
				}
		}
}
exports.reactHot = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.(js|jsx)$/,
										include: path,
										// loaders: ['react-hot', 'jsx'],
										loaders: ['jsx'],
										exclude: /node_modules/,
								}
						]
				},
				plugins: [
						new webpack.HotModuleReplacementPlugin()
				]
		}
}
exports.jsx = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.jsx$/,
										loader: 'jsx', // <-- changed line
										include: path,
										exclude: /node_modules/,
								}
						]
				}
		}
}
exports.minify = function() {
		return {
				plugins: [
						new webpack.optimize.UglifyJsPlugin({
								// Don't beautify output (enable for neater output)
								beautify: false,
								// Eliminate comments
								comments: false,
								// Compression specific options
								compress: {
										warnings: true,
										drop_console: true
								},
								mangle: {
										except: ['$'],
										screw_ie8: true,
										keep_fnames: true
								}
						})
				]
		};
}

exports.setFreeVariable = function(key, value) {
		const env = {};
		env[key] = JSON.stringify(value);

		return {
				plugins: [
						new webpack.DefinePlugin(env)
				]
		};
}
exports.extractBundle = function(options) {
		const entry = {};
		entry[options.name] = options.entries;

		return {
				// Define an entry point needed for splitting.
				entry: entry,
				plugins: [
						// Extract bundle and manifest files. Manifest is
						// needed for reliable caching.
						new webpack.optimize.CommonsChunkPlugin({
								names: [options.name, 'manifest']
						})
				]
		};
}
exports.clean = function(path) {
		return {
				plugins: [
						new CleanWebpackPlugin(path, {
								// Without `root` CleanWebpackPlugin won't point to our
								// project and will fail to work.
								root: process.cwd()
						})
				]
		};
}

exports.purifyCSS = function(paths) {
		return {
				plugins: [
						new PurifyCSSPlugin({
								basePath: process.cwd(),
								// `paths` is used to point PurifyCSS to files not
								// visible to Webpack. You can pass glob patterns
								// to it.
								paths: paths
						}),
				]
		}
}
exports.setupFile = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.(jpg|png|gif)$/,
										loader: 'url?limit=20000&name=./img/[hash].[ext]',
										include: path
								},
						]
				}
		}
}
exports.setupUrl = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.(jpg|png|gif)$/,
										loader: 'url?&name=./img/[hash].[ext]',
										include: path
								},
						]
				}
		}
}
exports.setupFonts = function(path) {
		return {
				module: {
						loaders: [
								{
										test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
										loader: 'url',
										include: path,
										query: {
												limit: 50000,
												mimetype: 'application/font-woff',
												name: './fonts/[hash].[ext]'
										}
								},
								{
										test: /\.ttf(\?v=\d+\.\d+\.\d+)?$|\.eot(\?v=\d+\.\d+\.\d+)?$/,
										loader: 'file',
										include: path,
										query: {
												name: './fonts/[hash].[ext]'
										},
								},
								{
										test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
										loader: 'file',
										include: path,
										query: {
												name: './fonts/[hash].[ext]'
										},
								}
						]
				}
		}
}
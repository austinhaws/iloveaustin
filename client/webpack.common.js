const path = require('path');
const fs = require('fs');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

// where does source live
const APP_DIR = path.resolve(__dirname, 'src/js');
const DTS_REACT_COMMON_NODE_MODULES = fs.realpathSync(__dirname + '/node_modules/dts-react-common');

// where does compiled code go
const BUILD_DIR = path.resolve(__dirname, 'dist');

// put the scss and css into a single file
const cssExtract = new MiniCssExtractPlugin({
	filename: '[name].[contenthash].css'
});

const htmlWebPack = new HtmlWebpackPlugin({
	template: 'src/index.html'
});

//copy static resources to the build directory
const copyStatic = new CopyWebpackPlugin([
	'src/static/',
]);

// tell it what file to starting compiling on and what to call it when done
const config = {
	entry: {
		examples: APP_DIR + '/app/App.jsx',
	},
	output: {
		path: BUILD_DIR,
		filename: '[name].[contenthash].bundle.js',
	},
	optimization: {
		runtimeChunk: 'single',
		splitChunks: {
			cacheGroups: {
				vendor: {
					test: /[\\/]node_modules[\\/]/,
					name: 'vendors',
					chunks: 'all'
				}
			}
		}
	},
	module : {
		rules : [
			// use babel loader
			{
				test : /\.jsx?$/,
				include : APP_DIR,
				loader : 'babel-loader',
				options: {
					configFile: './babel.config.js'
				}
			},
			{
				test : /\.jsx?$/,
				include : DTS_REACT_COMMON_NODE_MODULES,
				loader : 'babel-loader',
				options: {
					configFile: './babel.config.js'
				}
			},
			// SCSS and Single CSS file magic
			{
				test: /\.s?css$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
							url: true
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true
						}
					},
				],
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				use: [
					{
						loader: 'url-loader',
						options: {
							limit: 10000,
							fallback: 'file-loader',
							name: '[name].[ext]',
							outputPath: 'img/',
							emitFile: false,
						}
					}
				]
			},
			{
				test: /\.md$/,
				use: [
					{
						loader: 'raw-loader'
					}
				]
			}
		]
	},
	plugins: [
		cssExtract,
		copyStatic,
		htmlWebPack,
	],
	resolve: {
		extensions: ['.js', '.jsx', '.json'],
		//fix a bug in react-select that was finding two instances of react in each node_modules
		alias: { 'react': path.resolve(__dirname, 'node_modules', 'react') }
	},
};

module.exports = config;
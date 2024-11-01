const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
	cache: true,
	entry: './blocks.js',
	output: {
		path: path.resolve(__dirname, '../dist'), // the bundle output path
		filename: 'sv-forms.build.min.js', // the name of the bundle
		publicPath: '/',
	},
	plugins: [new MiniCssExtractPlugin()],
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/, // .js and .jsx files
				exclude: /node_modules/, // excluding the node_modules folder
				use: {
					loader: 'babel-loader',
				},
			},
			{ test: /\.css$/, use: [MiniCssExtractPlugin.loader, 'css-loader'] },
			{ test: /\.scss$/, use: [MiniCssExtractPlugin.loader, 'css-loader', {loader: 'postcss-loader'}, 'sass-loader'] },
		],
	}
};
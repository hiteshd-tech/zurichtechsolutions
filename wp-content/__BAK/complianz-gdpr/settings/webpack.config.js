const defaultConfig = require("@wordpress/scripts/config/webpack.config");

module.exports = {
	...defaultConfig,
	output: {
		...defaultConfig.output,
		filename: '[name].[contenthash].js',
		chunkFilename: '[name].[contenthash].js',
	},
	resolve: {
		...defaultConfig.resolve,
		fallback: {
			"path": require.resolve("path-browserify"),
		},
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.node$/,
				loader: 'node-loader',
			},
		],
	},
};
;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;
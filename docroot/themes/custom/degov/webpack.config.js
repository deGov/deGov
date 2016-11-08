const path = require('path');
const webpack = require('webpack');

module.exports = {
  cache: true,
  output: {
    filename: 'bundle.js'
  },
  resolve: {
    modulesDirectories: ['node_modules', 'source'],
    extensions: ['', '.js']
  },
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel',
      query: {
        presets: ['es2015']
      }
    }]
  },
  externals: {
    "jquery": "jQuery"
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV)
    }),
    new webpack.NoErrorsPlugin()
  ]
};

var path = require('path');
var webpack = require("webpack");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var HtmlWebpackPlugin = require('html-webpack-plugin');
var ngAnnotatePlugin = require('ng-annotate-webpack-plugin');
var Clean = require('clean-webpack-plugin');
var argv = require('minimist')(process.argv);
var bowerRoot = path.join(__dirname, '/bower_components');

var ENV = argv.env || 'development';
console.log("ENV:", ENV);

module.exports = {

    entry: {
        hostkey: [path.join(__dirname, '/src/hostkey')]
    },

    output: {
        path: path.join(__dirname, '/../assets/dist'),
        filename: '[name].js'
    },

    module: {
        loaders: [
            //{
            //    test: /\.js$/,
            //    loader: 'babel?optional=runtime',
            //    exclude: /node_modules/
            //},
            {
                test: /\.coffee$/, loader: "coffee"
            },
            {
                test: /\.css$/,
                loader: ExtractTextPlugin.extract("style-loader", "css-loader")
            },
            {
                test: /\.styl$/,
                loader: ExtractTextPlugin.extract("style-loader", "css-loader!stylus-loader")
            },
            {
                test: /\.less$/,
                loader: ExtractTextPlugin.extract("style-loader", "css-loader!less-loader")
            },
            {
                test: /\.(eot|woff|woff2|ttf|svg)$/,
                loader: 'file?prefix=fonts/'
            },
            {
                test: /\.(gif|png|jpg|ico)$/,
                loader: 'file?name=[name].[ext]'
            },
            {
                test: /\.jade/, loader: "jade"
            },
            {
                // angular views only
                test: /\.tpl\.html$/,
                loader: 'ng-cache'
            },
            {
                test: /\.(json)$/,
                loader: 'json'
            }
        ],

        // don't parse some dependencies to speed up build.
        // can probably do this non-AMD/CommonJS deps
        noParse: []
    },

    loader: {
        configEnvironment: ENV
    },

    devtool: "eval",

    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
        new ngAnnotatePlugin({
            add: true
            // other ng-annotate options here
        }),
        new ExtractTextPlugin("[name].css"),
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify('development')
        }),
    ],

    resolve: {
        alias: {
            bower: bowerRoot
        },

        extensions: [
            '',
            '.js',
            '.styl',
            '.less',
            '.coffee'
        ]
    }

};

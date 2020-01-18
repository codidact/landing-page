/* eslint-disable-next-line */
const webpack = require("webpack");
const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: path.resolve(__dirname, "../src/js/index.js"),

    output: {
        path: path.resolve(__dirname, "../dist"),
        filename: "assets/js/[name].js",
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ["babel-loader"],
            },
            {
                test: /\.scss$/,
                use: [
                    { loader: "style-loader" },
                    MiniCssExtractPlugin.loader,
                    { loader: "css-loader" },
                    { loader: "postcss-loader" },
                    { loader: "sass-loader" },
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "css/[name].css",
        }),
    ],
};

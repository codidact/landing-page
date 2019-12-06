const webpack = require("webpack");
const path = require("path");

module.exports = {
    entry: "./src/js/index.js",

    output: {
        path: path.resolve(__dirname, "dist"),
        filename: "js/[name].js",
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
                    { loader: "style-loader", options: { sourceMap: true } },
                    { loader: "css-loader", options: { sourceMap: true } },
                    { loader: "sass-loader", options: { sourceMap: true } },
                ],
            },
        ],
    },
    devtool: "cheap-eval-source-map",
    watch: true,
};

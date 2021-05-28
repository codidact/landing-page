const webpack = require("webpack");
const path = require("path");

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
                use: [{ loader: "style-loader" }, { loader: "css-loader" }, { loader: "sass-loader" }],
            },
        ],
    },
    devServer: {
        contentBase: ["./dist"],
        port: 3000,
    },
    devtool: "cheap-eval-source-map",
    watch: true,
};

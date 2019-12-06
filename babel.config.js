module.exports = api => {
    const isTest = api.env("test");

    if (isTest) {
        return {
            presets: [
                [
                    "@babel/preset-env",
                    {
                        targets: {
                            node: "current",
                        },
                    },
                ],
            ],
        };
    } else {
        return {
            presets: [["@babel/preset-env", { modules: false }]],
            plugins: ["@babel/plugin-proposal-class-properties"],
            overrides: [
                {
                    test: ["./config"],
                    presets: [
                        [
                            "@babel/preset-env",
                            {
                                modules: false,
                                targets: {
                                    browsers: [
                                        "last 2 Chrome versions",
                                        "last 2 Firefox versions",
                                        "last 2 Safari versions",
                                        "last 2 iOS versions",
                                        "last 1 Android version",
                                        "last 1 ChromeAndroid version",
                                    ],
                                },
                                useBuiltIns: "usage",
                                corejs: 3,
                            },
                        ],
                    ],
                },
            ],
        };
    }
};

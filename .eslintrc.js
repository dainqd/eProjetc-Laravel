module.exports = {
    env: {
        node: true,
    },
    extends: [
        "eslint:recommended",
    ],
    rules: {
        "max-len": [
            "off",
            {
                code: 120,
                ignoreComments: true,
                ignoreStrings: true,
            },
        ],
    },
};

const {getDefaultConfig, mergeConfig} = require('@react-native/metro-config');
const path = require('path');

/**
 * Metro configuration
 * https://facebook.github.io/metro/docs/configuration
 *
 * @type {import('metro-config').MetroConfig}
 */
const config = {
    resolver: {
        unstable_enableSymlinks: true,
        unstable_enablePackageExports: true,
    },
    watchFolders: [path.resolve(__dirname, 'node_modules')],
};

module.exports = mergeConfig(getDefaultConfig(__dirname), config);

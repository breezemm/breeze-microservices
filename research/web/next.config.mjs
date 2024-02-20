/** @type {import("next").NextConfig} */
export default {
  reactStrictMode: true,

  /** We already do linting and typechecking as separate tasks in CI */
  eslint: {ignoreDuringBuilds: true},
  typescript: {ignoreBuildErrors: true},
  transpilePackages: ['@breeze/ui'],
  pageExtensions: ["ts", "tsx", "mdx"],
}

// import type {Config} from "tailwindcss";
//
// import baseConfig from "@breeze/tailwind-config";
//
// export default {
//   // We need to append the path to the UI package to the content array so that
//   // those classes are included correctly.
//   content: [...baseConfig.content, "../../packages/ui/src/**/*.{ts,tsx}"],
//   presets: [baseConfig],
// } satisfies Config;

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

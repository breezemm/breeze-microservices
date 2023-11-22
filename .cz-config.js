module.exports = {
  types: [
    { value: "feat", name: "✨ feat:\tAdding a new feature" },
    { value: "fix", name: "🐛 fix:\tFixing a bug" },
    { value: "docs", name: "📝 docs:\tAdd or update documentation" },
    {
      value: "style",
      name: "💄 style:\tAdd or update styles, ui or ux",
    },
    {
      value: "refactor",
      name: "♻️  refactor:\tCode change that neither fixes a bug nor adds a feature",
    },
    {
      value: "perf",
      name: "⚡️ perf:\tCode change that improves performance",
    },
    {
      value: "test",
      name: "✅ test:\tAdding tests cases",
    },
    {
      value: "chore",
      name: "🚚 chore:\tChanges to the build process or auxiliary tools\n\t\tand libraries such as documentation generation",
    },
    { value: "revert", name: "⏪️ revert:\tRevert to a commit" },
    {
      value: "ci",
      name: "💚 ci:\tAdd or update regards to build process",
    },
  ],
  scopes: [],

  scopeOverrides: {
    fix: [
      { name: "merge" },
      { name: "style" },
      { name: "test" },
      { name: "hotfix" },
    ],
    build: [{ name: "profile" }, { name: "blog" }],
  },

  allowCustomScopes: true,
  allowBreakingChanges: ["feat", "fix"],
  skipQuestions: ["footer", "breaking", "body"],
  subjectLimit: 100,
};

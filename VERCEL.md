## Deployment on Vercel 🚀

### Git Setup in Vercel

We have to ignore build step in Vercel in terms of deployment. So we have to setup git in vercel.

`Settings` -> `Git` -> `Ignored Build Step` and add the following command.

```sh
git diff HEAD^ HEAD --quiet ./
```

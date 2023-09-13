# Breeze

The mono repo for the breeze microservices.

## Services and Design Decisions

| Service            | Description                                                                                                                 | Tech                            |
|--------------------|-----------------------------------------------------------------------------------------------------------------------------|---------------------------------|
| API Gateway        | The API Gateway is the entry point for all clients.<br/> It is responsible for routing requests to the appropriate service. | [Laravel](https://laravel.com/) | 
| Suggestion Service | The Suggestion Service is responsible for providing suggestions to the user.                                                | [Nest.js](https://nestjs.com/)  |

## Endpoints

| Service            | Endpoint                                      | 
|--------------------|-----------------------------------------------|
| API Gateway        | https://breeze-backend-api.vercel.app/        |
| Suggestion Service | https://breeze-suggestion-service.vercel.app/ |

## Deployment 🚀

### Git Setup in Vercel

We have to ignore build step in Vercel in terms of deployment. So we have to setup git in vercel.

`Settings` -> `Git` -> `Ignored Build Step`  and add the following command.

```sh
git diff HEAD^ HEAD --quiet ./
```

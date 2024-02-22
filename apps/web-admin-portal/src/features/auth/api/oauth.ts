import {axios} from "~/lib/axios.ts";

export const getOAuthToken = async () => {
  await axios.post('/oauth/authorize', {},{
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    params: {
      client_id: '9b641630-3b74-4d0f-8583-c1518b075527',
      redirect_uri: 'http://localhost:5173/auth/callback',
      response_type: 'code',
      scope: '',
      state: 'wWx2vyVmQ0mCjDeUrjtFArqQB5o01ztcYyDmiM4W'
    }
  })
}

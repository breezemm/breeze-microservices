package firebase

import (
	firebase "firebase.google.com/go"
	"firebase.google.com/go/messaging"
	"golang.org/x/net/context"
	"google.golang.org/api/option"
	"log"
)

func Init() {
	ctx := context.Background()
	opts := option.WithCredentialsFile("serviceAccountKey.json")

	app, err := firebase.NewApp(ctx, nil, opts)
	if err != nil {
		log.Fatal("Cannot initialize firebase app")
	}

	client, err := app.Messaging(context.Background())

	if err != nil {
		log.Fatal("Cannot initialize firebase messaging client")
	}

	message := &messaging.Message{
		Data: map[string]string{
			"score": "850",
			"time":  "2:45",
		},
		Topic: "highScores",
	}

	response, err := client.Send(ctx, message)
	if err != nil {
		log.Fatal("Cannot send message to firebase")
		return
	}

	log.Println("Successfully sent message:", response)

	registrationTokens := []string{
		"YOUR_REGISTRATION_TOKEN_1",
		// ...
		"YOUR_REGISTRATION_TOKEN_n",
	}

	resp, err := client.SubscribeToTopic(ctx, registrationTokens, "highScores")

	if err != nil {
		log.Fatal("Cannot subscribe to topic")
		return
	}

	log.Println("Successfully subscribed to topic:", resp.SuccessCount)
}

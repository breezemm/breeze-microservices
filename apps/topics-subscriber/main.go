package main

import (
  "github.com/gofiber/fiber/v2"
  "github.com/topics-subscriber/firebase"

  "log"
)

func main() {
  firebase.Init()
  app := fiber.New()

  app.Get("/", func(c *fiber.Ctx) error {
    return c.SendString("Hello, World!")
  })

  err := app.Listen(":3000")
  if err != nil {
    log.Fatal("Cannot serve golang server at port 3000")
    return
  }
}

import { Controller } from '@nestjs/common';
import { AppService } from './app.service';
import {
  Ctx,
  KafkaContext,
  MessagePattern,
  Payload,
} from '@nestjs/microservices';

@Controller()
export class AppController {
  constructor(private readonly appService: AppService) {}

  @MessagePattern('checkout')
  killDragon(@Payload() message: any, @Ctx() context: KafkaContext) {
    console.log(`Topic: ${context.getTopic()}`);

    console.log(message.data);

    console.log(JSON.parse(JSON.parse(message)).data);
  }
}

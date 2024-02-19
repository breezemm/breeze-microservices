const {CompressionTypes, CompressionCodecs, Kafka} = require('kafkajs')
const SnappyCodec = require('kafkajs-snappy')

CompressionCodecs[CompressionTypes.Snappy] = SnappyCodec

const kafka = new Kafka({
    clientId: 'my-app',
    brokers: ['kafka:9092',],
})


const consumer = kafka.consumer({groupId: 'd-groussp'});

const main = async () => {
    await consumer.connect()
    await consumer.subscribe({topic: 'wallets', fromBeginning: true})

    await consumer.run({
        eachMessage: async ({topic, partition, message}) => {
            console.log({
                value: JSON.parse(JSON.parse(JSON.stringify(message.value.toString())))
            })
        },
    })
}

main()
    .then(() => console.log('Consumer started'))
    .catch(console.error)

<?php
$conf = new RdKafka\Conf();
$conf->set('group.id', 'test_bitrix');
$conf->set('bootstrap.servers','10.6.2.43:9093,10.7.0.35:9093');

$consumer = new RdKafka\KafkaConsumer($conf);
$consumer->subscribe(['bitrix_1C_user']);

while (true) {
$message = $consumer->consume(120 * 1000); // Ожидание в течение 120 секунд


switch ($message->err) {
    case RD_KAFKA_RESP_ERR_NO_ERROR:
        echo 'Сообщение получено: ' . $message->payload . PHP_EOL;
        break;
    case RD_KAFKA_RESP_ERR__PARTITION_EOF:
        echo 'Достигнут конец раздела: ' . $message->payload . PHP_EOL;
        break;
    case RD_KAFKA_RESP_ERR__TIMED_OUT:
        echo 'Тайм-аут ожидания: ' . $message->payload . PHP_EOL;
        break;
    default:
        echo 'Ошибка: ' . $message->errstr() . PHP_EOL;
        break;
}
}
?>
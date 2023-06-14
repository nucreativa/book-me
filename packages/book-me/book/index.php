<?php

use Pheanstalk\Pheanstalk;
use Carbon\Carbon;

function main(array $args): array
{
  $pheanstalk = Pheanstalk::create(getenv('BEANSTALKD_HOST'));

  $now = Carbon::now()->minute(0)->second(0)->setTimezone('Asia/Jakarta');

  $book = [
    'product_id' => $args['product_id'],
    'date' => $args['date'] ?? date('Y-m-d'),
    'start_time' => $args['start'] ?? $now->toTimeString(),
    'end_time' => $args['end'] ?? $now->addHour()->toTimeString()
  ];

  // Queue a Job
  $pheanstalk
    ->useTube('booking-requests')
    ->put(json_encode($book));

  return ["body" => 'ok'];
}

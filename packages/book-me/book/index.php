<?php

use Pheanstalk\Pheanstalk;
use Carbon\Carbon;

function main(array $args): array
{
  $pheanstalk = Pheanstalk::create(getenv('beanstalkd_host'));

  $now = Carbon::now()->minute(0)->second(0)->setTimezone('Asia/Jakarta');

  $book = [
    'date' => $args['date'] ?? date('Y-m-d'),
    'start' => $args['start'] ?? $now->toTimeString(),
    'end' => $args['end'] ?? $now->addHour()->toTimeString()
  ];

  // Queue a Job
  $pheanstalk
    ->useTube('booking-requests')
    ->put(json_encode($book));

  return ["body" => 'ok'];
}

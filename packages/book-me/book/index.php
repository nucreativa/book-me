<?php

use Pheanstalk\Pheanstalk;
use Carbon\Carbon;

function main(array $args): array
{
  $pheanstalk = Pheanstalk::create(getenv('beanstalkd_host'));

  $book = [
    'date' => $args['date'] ?? date('Y-m-d'),
    'start' => $args['start'] ?? Carbon::now()->minute(0)->second(0)->toTimeString(),
    'end' => $args['end'] ?? Carbon::now()->addHour()->minute(0)->second(0)->toTimeString()
  ];

  // Queue a Job
  $pheanstalk
    ->useTube('booking-requests')
    ->put(json_encode($book));

  return ["body" => 'ok'];
}

<?php

$xml = simplexml_load_file('https://gorodrabot.ru/feed/yandex.xml');

foreach ($xml->vacancies->vacancy as $vacancy) {

    $jobUrl = (string) $vacancy->url;
    $propertyName = 'job-name';
    $jobName = (string) $vacancy->$propertyName;

    echo "Вакансия: $jobName\n";
    echo "URL: $jobUrl\n\n";
}

?>
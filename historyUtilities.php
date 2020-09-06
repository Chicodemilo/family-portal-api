<?php

// historyUtilities
class HistoryUtilities
{
    public $eventCount;
    public $birthCount;
    public $deathCount;
    public $date;
    public $text;

    public function __construct($data)
    {
        $this->data = $data;
        $this->setStuff();
        $this->pickEvent();
        $this->pickBirth();
        $this->pickDeath();
    }

    public function pickType()
    {
        $type = ['event', 'birth', 'death'];
        return $type[rand(0, 2)];
    }

    public function setStuff()
    {
        $this->date = $this->data['date'];
        $this->eventCount = count($this->data['data']['Events']) - 1;
        $this->birthCount = count($this->data['data']['Births']) - 1;
        $this->deathCount = count($this->data['data']['Deaths']) - 1;
    }

    public function pickEvent()
    {
        $tries = 3;
        $eventNum = rand(0, $this->eventCount);

        while ($tries > 1 && $this->newerTest($eventNum, $this->eventCount)) {
            $tries -= 1;
            $eventNum = rand(0, $this->eventCount);
        };

        $event = $this->data['data']['Events'][$eventNum];
        $this->text .= $this->date . " " . $event['year'] . ": " . $event['text'] . ":::";
    }

    private function pickBirth()
    {
        $birthNum1 = rand(0, $this->birthCount);
        $birthNum2 = rand(0, $this->birthCount);
        $birthNum3 = rand(0, $this->birthCount);

        $tries = 3;
        $birthNum1 = rand(0, $this->birthCount);
        while ($tries > 1 && $this->newerTest($birthNum1, $this->birthCount)) {
            $tries -= 1;
            $birthNum1 = rand(0, $this->birthCount);
        };

        $birth = $this->data['data']['Births'][$birthNum1];
        // $birth2 = $this->data['data']['Births'][$birthNum2];
        // $birth3 = $this->data['data']['Births'][$birthNum3];

        $this->text .= "Born Today  " . $birth['year'] . ": " . $birth['text'] . ":::";
        // $this->text .= "Born Today  " . $birth2['year'] . ": " . $birth2['text'] . ":::";
        // $this->text .= "Born Today  " . $birth3['year'] . ": " . $birth3['text'] . ":::";
    }

    private function pickDeath()
    {
        $tries = 3;
        $deathNum = rand(0, $this->deathCount);
        while ($tries > 1 && $this->newerTest($deathNum, $this->deathCount)) {
            $tries -= 1;
            $deathNum = rand(0, $this->deathCount);
        };
        $death = $this->data['data']['Deaths'][$deathNum];
        $this->text .= "Died Today  " . $death['year'] . ": " . $death['text'];
    }

    private function newerTest($num, $total)
    {
        $max = round((($total / 3) * 2), 0);
        return !($num > $max);
    }
}
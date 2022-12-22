<?php

class MtrSegment extends Segment
{
    private string $line;
    private string $station;
    private string $direction;

    public function __construct($name, string $line, string $station, string $direction)
    {
        parent::__construct($name);

        $this->line = $line;
        $this->station = $station;
        $this->direction = $direction;
    }

    public function retrieveData(): void
    {
        $response = call(
            "https://rt.data.gov.hk/v1/transport/mtr/getSchedule.php?line={line}&sta={station}",
            [
                "line" => $this->line,
                "station" => $this->station
        ]);

        $access = $this->line . "-" . $this->station;
        $direction = $this->direction;

        $this->data = $response->data->$access->$direction ?? [];
    }

    private function renderingTemplate($formatDate): string
    {
        return sprintf(
            "<ul class='p-2 flex justify-around text-center'>%s</ul>",
            join(array_map(fn($train) => "<li>" . $formatDate($train->time) . "</li>", $this->data))
            );
    }

    protected function renderTime(): string
    {
        return $this->renderingTemplate(
            fn ($date) => \DateTime::createFromFormat("Y-m-d H:i:s", $date, new DateTimeZone(HONG_KONG_TZ))->format("H:i")
        );
    }

    protected function renderWait(): string
    {
        return $this->renderingTemplate(
            fn ($date) => minutesFromNow(\DateTime::createFromFormat("Y-m-d H:i:s", $date, new DateTimeZone(HONG_KONG_TZ)))
        );
    }
}

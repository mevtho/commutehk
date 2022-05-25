<?php

class BusSegment extends Segment
{
    public string $stop;
    public array $routes;

    public function __construct($name, string $stop, array $routes)
    {
        parent::__construct($name);

        $this->stop = $stop;
        $this->routes = $routes;
    }

    public function retrieveData(): void
    {
        global $busRouteCompanies;

        $this->data = [];

        foreach ($this->routes as $route) {
            $this->data[$route] = [];
            foreach ($busRouteCompanies[$route] as $company) {
                $response = call(
                    "https://rt.data.gov.hk/v1.1/transport/citybus-nwfb/eta/{company_id}/{stop_id}/{route}",
                    [
                        "company_id" => $company,
                        "stop_id" => $this->stop,
                        "route" => $route
                    ]
                );

                $this->data[$route] = [
                    ...$this->data[$route],
                    ...$response->data
                ];
            }
            uasort($this->data[$route], fn($a, $b) => strcmp($a->eta, $b->eta));
        }
    }

    private function renderingTemplate($formatDate): string
    {
        return sprintf(
            "<ul>%s</ul>",
            join(array_map(function ($route) use ($formatDate) {
                $liStyle = "inline px-1 min-w-[40px]";

                return sprintf(
                    "<li class=\"flex items-top\"><div class=\"flex-shrink-0 w-[40px] text-center font-extrabold\">%s</div><ul class=\"flex flex-wrap\">%s</ul></li>",
                    $route,
                    count($this->data[$route]) === 0
                        ? "<li class='$liStyle text-left'>-</li>"
                        : join(
                        array_map(
                            fn($bus) => sprintf("<li class='$liStyle text-center'>%s</li>", $formatDate($bus->eta)),
                            $this->data[$route]
                        )
                    )
                );
            }, array_keys($this->data)))
        );
    }

    protected function renderTime(): string
    {
        return $this->renderingTemplate(fn ($date) => \DateTime::createFromFormat(DateTime::ATOM, $date)->format("H:i:s"));
    }

    protected function renderWait(): string
    {
        return $this->renderingTemplate(fn ($date) => minutesFromNow(\DateTime::createFromFormat(DateTime::ATOM, $date)));
    }
}

<?php

abstract class Segment
{
    public string $name = "";

    protected mixed $data = null;

    const VIEW_TIME = "time";
    const VIEW_WAIT = "wait";
    const VIEW_ASAP = "asap";

    protected function __construct($name = "")
    {
        $this->name = $name;
    }

//    private function callData($what, $params)
//    {
//        $url = match ($what) {
//            "bus_stop" => "https://rt.data.gov.hk/v1.1/transport/citybus-nwfb/stop/{stop_id}",
//            "bus_eta" => "https://rt.data.gov.hk/v1.1/transport/citybus-nwfb/eta/{company_id}/{stop_id}/{route}",
//            "mtr_eta" => "https://rt.data.gov.hk/v1/transport/mtr/getSchedule.php?line={line}&sta={station}",
//            default => null
//        };
//
//        if (!$url) {
//            return null;
//        }
//
//        $fn = "../cache/bs-" . md5($url . json_encode($params)) . ".json";
//        if (USE_CACHE) {
//            if (file_exists($fn)) {
//                return json_decode(file_get_contents($fn));
//            }
//        }
//
//        $response = call($url, $params);
//
//        if (USE_CACHE) {
//            file_put_contents($fn, $response);
//        }
//
//        return json_decode($response);
//    }

    public function render($view = "time"): string
    {
        return sprintf(
            "<div><div class=\"p-2 bg-primary-200 font-extrabold\">%s</div>%s</div>",
            $this->name,
            match ($view) {
                self::VIEW_WAIT => $this->renderWait(),
                self::VIEW_ASAP => $this->renderAsap(),
                default => $this->renderTime()
            }
        );
    }

    abstract public function retrieveData(): void;

    abstract protected function renderTime(): string;

    abstract protected function renderWait(): string;
}

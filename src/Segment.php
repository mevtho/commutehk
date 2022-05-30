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

    public function render($view = "time"): string
    {
        return sprintf(
            "<div><div class=\"p-2 bg-primary-200 font-extrabold\">%s</div>%s</div>",
            $this->name,
            match ($view) {
                self::VIEW_WAIT => $this->renderWait(),
                default => $this->renderTime()
            }
        );
    }

    abstract public function retrieveData(): void;

    abstract protected function renderTime(): string;

    abstract protected function renderWait(): string;
}

<?php

class RoutePage extends Page
{
    // Return `title_short` if exists, else normal title
    public function shortTitle()
    {
        if (!$this->title_short()->empty()) {
            $shortTitle = $this->title_short();
        } else {
            $shortTitle = $this->title();
        };

        return $shortTitle;
    }

    // Return `line` name if exists, else defer to company title
    public function currentTitle()
    {
        if (!$this->line()->empty()) {
            $currentTitle = $this->line();
        } else {
            $currentTitle = page('companies/'.$this->company())->title();
        };

        return $currentTitle;
    }

    // Return `desc` if exists, else excerpt of text
    public function excerpt()
    {
        if (!$this->desc()->empty()) {
            $excerpt = $this->desc();
        } else {
            $excerpt = excerpt($this->text(), $length = 40, $mode = 'words');
        };

        return $excerpt;
    }
}

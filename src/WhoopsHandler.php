<?php

namespace Swoft\Whoops;

use Whoops\Run;

class WhoopsHandler
{

    private $whoops;

    public function getWhoopsInstance()
    {
        if (empty($this->_whoops)) {
            $this->whoops = new Run();
        }

        return $this->whoops;
    }

}

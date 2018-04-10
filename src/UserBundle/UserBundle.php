<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    function getParent()  {
        return "FOSUserBundle";
    }
}

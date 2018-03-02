<?php

namespace ParentingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ParentingBundle extends Bundle
{
    public function getParent()
    {
        return 'DForumBundle';
    }
}

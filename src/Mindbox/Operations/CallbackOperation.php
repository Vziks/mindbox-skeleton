<?php


namespace App\Mindbox\Operations;


use Symfony\Component\HttpFoundation\Request;

class CallbackOperation extends AbstractOperation
{

    public function getName()
    {
        return 'callback';
    }

}
<?php
namespace Baohanddd\Request\Loader;

class Factory
{
    public function model()
    {
        return new Namespaces('\App\Model');
    }

    public function vo()
    {
        return new Namespaces('\App\Model\Match\VO');
    }

    public function bo()
    {
        return new Namespaces('\App\Model\Match\BO');
    }
}
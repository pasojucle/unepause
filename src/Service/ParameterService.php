<?php

namespace App\Service;

use App\Entity\Parameter;
use Doctrine\Common\Persistence\ObjectManager;

class ParameterService
{
    private $manager;
    private $parametersArray;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

        $parameters = $this->manager->getRepository(Parameter::class)->findAll();
        $this->parametersArray = [];
        foreach ($parameters as $parameter) {
            $this->parametersArray[$parameter->getName()] = $parameter->getValue();
            if ('company' == $parameter->getName()) {
                $value = preg_replace_callback('/\s(.?)/',function($matches) {return strtoupper(ltrim($matches[0]));}, strtolower($parameter->getValue()));
                $this->parametersArray['lowerCamelcase'] = $value;
                $value = preg_replace('/\s/','-', strtolower($parameter->getValue()));
                $this->parametersArray['dashCase'] = $value;
            }
        }
    }

    public function getparameters() {
        return $this->parametersArray;
    }

    public function getEmail() {
        return $this->parametersArray['email'];
    }

    public function getCompany() {
        return $this->parametersArray['company'];
    }
}
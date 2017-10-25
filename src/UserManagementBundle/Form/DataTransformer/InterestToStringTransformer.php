<?php

// src/AppBundle/Form/DataTransformer/IssueToNumberTransformer.php
namespace UserManagementBundle\Form\DataTransformer;

use UserManagementBundle\Entity\Interest;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Exception\TransformationFailedException;

class InterestToStringTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (interest) to a string (name).
     *
     * @param  Interest|null $interest
     * @return string
     */
    public function transform($intetest)
    {
        if (null === $intetest) {
            return '';
        }

        return $intetest->getName();
    }

    /**
     * Transforms a string (name) to an object (intetest).
     *
     * @param  string $interestArea
     * @return Interest|null
     * @throws TransformationFailedException if object (interest) is not found.
     */
    public function reverseTransform($interestArea)
    {
//        dump($interestArea); die();
        // no issue number? It's optional, so that's ok
        if (!$interestArea) {
            return;
        }

        $intetest = $this->em
            ->getRepository(Interest::class)
            // query for the issue with this id
            ->findOneBy(array('name' => $interestArea))
        ;
//        dump($intetest); die();

        if (null === $intetest) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An interest with name "%s" does not exist!',
                $interestArea
            ));
//            throw new Exception(sprintf(
//                'An interest with name "%s" does not exist!',
//                $interestArea));
        }

        return $intetest;
    }
}
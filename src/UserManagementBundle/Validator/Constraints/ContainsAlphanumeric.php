<?php

namespace UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
    public $message = 'The string "{{ string }}" contains an illegal character: it can only contain letters or numbers.';
        
    public function validatedBy()
    {
        return 'alpha_numeric';
    }

    public function getTargets()
    {
        return array(self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT);
    }
    
}

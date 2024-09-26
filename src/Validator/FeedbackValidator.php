<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FeedbackValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        $positiveCount = 0;
        $negativeCount = 0;

        foreach ($value as $feedback) {
            if ($feedback->getType() === 'positif') {
                $positiveCount++;
            } elseif ($feedback->getType() === 'negatif') {
                $negativeCount++;
            }
        }

        if ($positiveCount < 1) {
            $this->context->buildViolation('Vous devez fournir au moins un feedback positif.')
                ->addViolation();
        }

        if ($negativeCount < 1) {
            $this->context->buildViolation('Vous devez fournir au moins un feedback négatif.')
                ->addViolation();
        }
    }
}
<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Feedback extends Constraint
{
    public string $message = 'Le feedback n\'est pas valide.';

    public function validatedBy(): string
    {
        return FeedbackValidator::class;
    }
}
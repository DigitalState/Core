<?php

namespace Ds\Component\Translation\Validator;

use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Service\TranslationService;
use LogicException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ValidValidator
 *
 * @package Ds\Component\Translation
 */
final class ValidValidator extends ConstraintValidator
{
    /**
     * @var \Ds\Component\Translation\Service\TranslationService
     */
    private $translationService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Translation\Service\TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Validate value
     *
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Translatable) {
            throw new LogicException('Value is not translatable while trying to validate translations.');
        }

        $locales = [];

        foreach ($value->getTranslations() as $translation) {
            $locales[] = $translation->getLocale();
        }

//        $this->context
//            ->buildViolation($constraint->getMessage())
//            ->atPath('')
//            ->addViolation();
    }
}

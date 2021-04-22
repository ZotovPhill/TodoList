<?php

namespace App\Service\ParamConverter;

use App\Exception\RequestObjectPayloadException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestObjectConverter implements ParamConverterInterface {

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        /** @var RequestObject $object */
        $object = new $class;
        $object->setPayload(
            array_merge(
                $request->request->all(),
                $request->files->all()
            )
        );

        $errors = $this->validator->validate(
            $object->all(),
            $object->rules(),
            $object->groups()
        );

        if (count($errors) !== 0) {
            throw new RequestObjectPayloadException($object, $errors);
        }

        $request->attributes->set(
            $configuration->getName(),
            $object
        );
    }

    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), RequestObject::class);
    }
}

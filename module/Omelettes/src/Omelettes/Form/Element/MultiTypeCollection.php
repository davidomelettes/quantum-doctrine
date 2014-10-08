<?php

namespace Omelettes\Form\Element;

use Traversable;
use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;
use Zend\Form\Fieldset;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\Stdlib\ArrayUtils;

class MultiTypeCollection extends RemovableCollection
{
    /**
     * Array of type keys => target elements
     *
     * @var array
     */
    protected $targetMap = array();

    /**
     * Which type to use when displaying default targets
     *
     * @var string
    */
    protected $defaultType;

    /**
     * A map of types to human-readable labels
     *
     * @var array
     */
    protected $typeLabels = array();

    /**
     * A template of each element type
     *
     * @var array
    */
    protected $templateElements = array();

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['target_map'])) {
            $this->setTargetMap($options['target_map']);
        }

        if (isset($options['type_labels'])) {
            $this->setTypeLabels($options['type_labels']);
        }

        if (!isset($options['default_type'])) {
            throw new Exception\InvalidArgumentException('default_type option not specified');
        }
        $this->setDefaultType($options['default_type']);

        return $this;
    }

    public function setTargetMap(array $map)
    {
        $targetMap = array();
        foreach ($map as $type => $elementOrFieldset) {
            if (is_array($elementOrFieldset)
            || ($elementOrFieldset instanceof Traversable && !$elementOrFieldset instanceof ElementInterface)
            ) {
                $factory = $this->getFormFactory();
                $elementOrFieldset = $factory->create($elementOrFieldset);
            }

            if (!$elementOrFieldset instanceof ElementInterface) {
                throw new Exception\InvalidArgumentException(sprintf(
                        '%s requires that $elementOrFieldset be an object implementing %s; received "%s"',
                        __METHOD__,
                        __NAMESPACE__ . '\ElementInterface',
                        (is_object($elementOrFieldset) ? get_class($elementOrFieldset) : gettype($elementOrFieldset))
                ));
            }

            $targetMap[$type] = $elementOrFieldset;
        }

        $this->targetMap = $targetMap;

        return $this;
    }

    public function getTargetMap()
    {
        return $this->targetMap;
    }

    public function setTypeLabels(array $labels)
    {
        return $this->typeLabels = $labels;
    }

    public function getTypeLabels()
    {
        return $this->typeLabels;
    }

    public function getTypeLabel($type)
    {
        if (!isset($this->targetMap[$type])) {
            throw new \Exception('Type not present in map: ' . $type);
        }
        if (isset($this->typeLabels[$type])) {
            return $this->typeLabels[$type];
        } else {
            return get_class($this->targetMap[$type]);
        }
    }

    public function setDefaultType($type)
    {
        $this->defaultType = $type;
        return $this;
    }

    public function getDefaultType()
    {
        return $this->defaultType;
    }

    /**
     * Create a new instance of the target element
     *
     * @return ElementInterface
     */
    protected function createNewTargetElementInstance($type)
    {
        return clone $this->targetMap[$type];
    }

    /**
     * Add a new instance of the target element
     *
     * @param string $name
     * @return ElementInterface
     * @throws Exception\DomainException
     */
    protected function addNewTargetElementInstance($name, $type)
    {
        $this->shouldCreateChildrenOnPrepareElement = false;

        $elementOrFieldset = $this->createNewTargetElementInstance($type);
        $elementOrFieldset->setName($name);

        $this->add($elementOrFieldset);

        if (!$this->allowAdd && $this->count() > $this->count) {
            throw new Exception\DomainException(sprintf(
                    'There are more elements than specified in the collection (%s). Either set the allow_add option ' .
                    'to true, or re-submit the form.',
                    get_class($this)
            ));
        }

        return $elementOrFieldset;
    }

    /**
     * Populate values
     *
     * @param array|Traversable $data
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     * @return void
     */
    public function populateValues($data)
    {
        if (!is_array($data) && !$data instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                    '%s expects an array or Traversable set of data; received "%s"',
                    __METHOD__,
                    (is_object($data) ? get_class($data) : gettype($data))
            ));
        }

        // Can't do anything with empty data
        if (empty($data)) {
            //return;
        }

        if (!$this->allowRemove && count($data) < $this->count) {
            throw new Exception\DomainException(sprintf(
                    'There are fewer elements than specified in the collection (%s). Either set the allow_remove option '
                    . 'to true, or re-submit the form.',
                    get_class($this)
            ));
        }

        // Check to see if elements have been replaced or removed
        foreach ($this->byName as $name => $elementOrFieldset) {
            if (isset($data[$name])) {
                continue;
            }

            if (!$this->allowRemove) {
                throw new Exception\DomainException(sprintf(
                        'Elements have been removed from the collection (%s) but the allow_remove option is not true.',
                        get_class($this)
                ));
            }

            $this->remove($name);
        }

        foreach ($data as $key => $value) {
            if (!isset($value['type'])) {
                continue;
            }

            if ($this->has($key)) {
                $elementOrFieldset = $this->get($key);
            } else {
                $elementOrFieldset = $this->addNewTargetElementInstance($key, $value['type']);

                if ($key > $this->lastChildIndex) {
                    $this->lastChildIndex = $key;
                }
            }

            if ($elementOrFieldset instanceof FieldsetInterface) {
                $elementOrFieldset->populateValues($value);
            } else {
                $elementOrFieldset->setAttribute('value', $value);
            }
        }

        if (!$this->createNewObjects()) {
            $this->replaceTemplateObjects();
        }
    }

    /**
     * Prepare the collection by adding a dummy template element if the user want one
     *
     * @param  FormInterface $form
     * @return mixed|void
     */
    public function prepareElement(FormInterface $form)
    {
        if (true === $this->shouldCreateChildrenOnPrepareElement) {
            if ($this->targetElement !== null && $this->count > 0) {
                while ($this->count > $this->lastChildIndex + 1) {
                    $this->addNewTargetElementInstance(++$this->lastChildIndex, $this->defaultType);
                }
            }
        }

        // Create a template that will also be prepared
        if ($this->shouldCreateTemplate) {
            foreach ($this->getTargetMap() as $type => $target) {
                $templateElement = $this->getTemplateElement($type);
                $this->add($templateElement);
            }
        }

        Fieldset::prepareElement($form);

        // The template element has been prepared, but we don't want it to be rendered nor validated, so remove it from the list
        if ($this->shouldCreateTemplate) {
            foreach ($this->getTargetMap() as $type => $target) {
                $this->remove($this->templatePlaceholder.$type.'__');
            }
        }
    }

    /**
     * @return array
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     * @throws \Zend\Form\Exception\InvalidElementException
     */
    public function extract()
    {

        if ($this->object instanceof Traversable) {
            $this->object = ArrayUtils::iteratorToArray($this->object, false);
        }

        if (!is_array($this->object)) {
            return array();
        }

        $values = array();

        foreach ($this->object as $key => $value) {
            if ($this->hydrator) {
                $values[$key] = $this->hydrator->extract($value);
            } else {
                foreach ($this->targetMap as $type => $targetObject) {
                    if ($value instanceof $targetObject->object) {
                        // @see https://github.com/zendframework/zf2/pull/2848
                        $targetElement = clone $this->targetMap[$type];
                        $targetElement->object = $value;
                        $values[$key] = $targetElement->extract();
                        if (!$this->createNewObjects() && $this->has($key)) {
                            $fieldset = $this->get($key);
                            if ($fieldset instanceof Fieldset && $fieldset->allowObjectBinding($value)) {
                                $fieldset->setObject($value);
                            }
                        }
                        continue;
                    }
                }
            }
        }
        return $values;
    }

    /**
     * Create a dummy template element
     *
     * @return null|ElementInterface|FieldsetInterface
     */
    protected function createTemplateElement($type)
    {
        if (!$this->shouldCreateTemplate) {
            return null;
        }

        if (isset($this->templateElements[$type])) {
            return $this->templateElements[$type];
        }

        $elementOrFieldset = $this->createNewTargetElementInstance($type);
        $elementOrFieldset->setName($this->templatePlaceholder.$type.'__');

        return $elementOrFieldset;
    }

    /**
     * Get a template element used for rendering purposes only
     *
     * @return null|ElementInterface|FieldsetInterface
     */
    public function getTemplateElement($type)
    {
        if (!isset($this->templateElements[$type])) {
            $this->templateElements[$type] = $this->createTemplateElement($type);
        }

        return $this->templateElements[$type];
    }

}

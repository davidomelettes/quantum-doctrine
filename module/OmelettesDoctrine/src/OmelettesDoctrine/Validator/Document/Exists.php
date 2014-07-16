<?php

namespace OmelettesDoctrine\Validator\Document;

class Exists extends AbstractDocumentValidator
{
    const ERROR_DOCUMENT_DOES_NOT_EXIST = 'noDocument';
    
    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_DOCUMENT_DOES_NOT_EXIST => "No object matching '%value%' was found",
    );
    
    public function isValid($value)
    {
        $this->setValue($value);
        
        $result = $this->documentService->findBy($this->field, $value);
        if (!$result) {
            $this->error(self::ERROR_DOCUMENT_DOES_NOT_EXIST, $value);
            return false;
        }
        
        return true;
    }
    
}
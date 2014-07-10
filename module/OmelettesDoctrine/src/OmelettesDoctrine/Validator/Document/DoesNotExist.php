<?php

namespace OmelettesDoctrine\Validator\Document;

class DoesNotExist extends AbstractDocumentValidator
{
    const ERROR_DOCUMENT_EXISTS = 'documentFound';
    
    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_DOCUMENT_EXISTS => "An object matching '%value%' was found",
    );
    
    public function isValid($value)
    {
        $result = $this->documentService->findBy($this->field, $value);
        if ($result) {
            $this->error(self::ERROR_DOCUMENT_EXISTS, $value);
            return false;
        }
        
        return true;
    }
    
}
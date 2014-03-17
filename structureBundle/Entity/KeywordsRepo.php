<?php
namespace EuroLiterie\structureBundle\Entity;

use EuroLiterie\structureBundle\XML\MyXml;

class KeywordsRepo extends MyXml
{

    public function getGeneralKeywords()
    {
        $xml = new \SimpleXmlElement(file_get_contents($this->getXmlFilePath('keyword')));
        foreach ($xml as $general)
        {
            $keywords = (string) $general->keywords;
        }
        return $keywords;
    }

    public function save($keywords)
    {
        $xml = new \simpleXmlElement(file_get_contents($this->getXmlFilePath('keyword')));
        foreach($xml as $general)
        {
            $general->keywords = $keywords;
        }
        $xml->asXml($this->getXmlFilePath('keyword'));
    }
    
}

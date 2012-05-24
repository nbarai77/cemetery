<?php

class languageComponents extends sfComponents
{
  public function executeLanguage(sfWebRequest $request)
  {
        // Get cms page list for listing.
        $this->oGuardGroupPageListQuery = Doctrine::getTable('Language')->getAllLanguages();    
        $this->culture = $this->getUser()->getCulture();
  }
}

<?php
/**
 * Custom file upload validation class for overriding generateFilename method to get the original filename.
 * With gratitude from:
 * 	http://stackoverflow.com/questions/2135414/how-do-i-retain-the-original-filename-after-upload-in-symfony
 */
class emValidatedFile extends sfValidatedFile {
  public function generateFilename() {
   $file_remove_space = strtr($this->getOriginalName(), ' ', '_');
    return time()."_".$file_remove_space;
  }
}
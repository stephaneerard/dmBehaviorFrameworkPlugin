<?php

/**
 * Description of dmBehaviorableForm
 *
 * @author TheCelavi
 */
class dmBehaviorableForm extends dmWidgetPluginForm {
    
    public function configure() {
        parent::configure();
        $this->widgetSchema['behaviors'] = new dmWidgetFormBehaviors();
        $this->validatorSchema['behaviors'] = new sfValidatorString(
                array('required'=>false)
        );
        $this->getWidgetSchema()->setHelp('behaviors', 'Attach behaviors to this widget from the bottom menu');
    }
    
    public function getStylesheets() {
        return array_merge(
            parent::getStylesheets(),            
            array()
        );
    }
    public function getJavaScripts() {
        return array_merge(
            parent::getJavaScripts(),            
            array()
        );
    }
    
}

?>

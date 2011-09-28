<?php

/**
 * Description of dmBehaviorsManager
 *
 * @author TheCelavi
 */
class dmBehaviorsManager {

    private static $instance = null;
    
    private $behaviors = array();

    private function __construct() {
        sfContext::getInstance()->getConfigCache()->registerConfigHandler('config/dm/behaviors.yml', 'dmBehaviorsConfigHandler', array());
        include sfContext::getInstance()->getConfigCache()->checkConfig('config/dm/behaviors.yml');
    }

    public static function getInstance() {
        if (!is_null(self::$instance))
            return self::$instance;
        else
            self::$instance = new dmBehaviorsManager();
        return self::$instance;
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }

    public function renderBehaviorsToolbar() {              
        $helper = dmContext::getInstance()->getHelper();
        return $helper->renderPartial('dmBehaviorFramework', 'add_behaviors_menu', array(
            'behaviors' => sfConfig::get('dm_behaviors')
        ));
    }
    
    public function getBehaviorSettings($behaviorID) {
        $behaviors = sfConfig::get('dm_behaviors');
        $result = null;
        $sectionName = null;
        foreach ($behaviors as $section) {
            $sectionName = $section['section_name'];
            foreach ($section['behaviors'] as $key=>$behavior) {
                if ($key == $behaviorID) {
                    $result = $behavior;
                    break;
                }
                if (!is_null($result)) break;
            }
            if (!is_null($result)) break;
        }
        if (is_null($result)) return null; // TODO THROW USER ERROR HERE
        else return array(
            'dmBehaviorSection'     =>      $sectionName,
            'dmBehaviorKey'         =>      $behaviorID,
            'dmBehaviorName'        =>      $result['name'],
            'dmBehaviorIcon'        =>      $result['icon'],
            'dmBehaviorForm'        =>      $result['form'],
            'dmBehaviorView'        =>      $result['view'],
        );
    }
    
    public function registerBehaviors($widgetValues) {
        $values = json_decode($widgetValues, true);
        foreach ($values as $key=>$val) {
            if ($key == 'behaviors') {
                return $this->extractBehaviorsSettings($val);
            }
        }        
        return false;
    }
    
    protected function extractBehaviorsSettings($value) {
        $values = json_decode($value, true);
        $result = array();
        foreach ($values as $val) {            
            unset ($val['dmBehaviorTempID']);            
            if (!isset ($this->behaviors[$val['dmBehaviorKey']])) {                
                $val = array_merge($val, $this->getBehaviorSettings($val['dmBehaviorKey']));
                $this->behaviors[$val['dmBehaviorKey']] = new $val['dmBehaviorView'](dmContext::getInstance());
            }           
            $this->behaviors[$val['dmBehaviorKey']]->addSettings($val);
            $result[$val['dmBehaviorKey']][] = $this->behaviors[$val['dmBehaviorKey']]->filterSettings($val);
        }
        return $result;
    }    
    
    public function getJavascripts() {
        $js = array();
        foreach ($this->behaviors as $behavior) {
            $js = array_merge($js, $behavior->getJavascripts());
        }
        return $js;
    }
    
    public function getStylesheets() {
        $css = array();
        foreach ($this->behaviors as $behavior) {
            $css = array_merge($css, $behavior->getStylesheets());            
        }
        return $css;
    }
}

?>

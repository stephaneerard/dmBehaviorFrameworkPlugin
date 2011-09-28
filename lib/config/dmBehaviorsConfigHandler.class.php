<?php

/**
 * Description of dmBehaviorsConfigHandler
 *
 * @author TheCelavi
 */
class dmBehaviorsConfigHandler extends sfYamlConfigHandler {
    
    public function execute($configFiles) {
        $config = array();
        foreach ($configFiles as $file) {
            $tmp = $this->parseYaml($file);
            foreach($tmp['dmBehaviors'] as $key=>$value) {
                $sectionKey = dmString::slugify($value['section']);
                if (!isset($config[$sectionKey])) {
                    $config[$sectionKey] = array(
                        'section_name' => $value['section'],
                        'behaviors' => array()
                    );
                    
                } 
                $config[$sectionKey]['behaviors'][$key] = array(
                    'name' => (isset($value['name'])) ? $value['name'] : dmString::humanize($key),
                    'icon' => (isset($value['icon'])) ? $value['icon'] : '/dmBehaviorFrameworkPlugin/images/icon.png',
                    'form' => (isset($value['form'])) ? $value['form'] : 'dm'.dmString::camelize($key).'BehaviorForm',
                    'view' => (isset($value['view'])) ? $value['view'] : 'dm'.dmString::camelize($key).'BehaviorView'
                );
                
            }
            
            
            
        }
        
        $retval = sprintf("<?php\n" .
                "// auto-generated by %s\n" .
                "// date: %s\nsfConfig::set('dm_behaviors', \n%s\n);\n?>", __CLASS__, date('Y/m/d H:i:s'), var_export($config, true));
        
        return $retval;
    }
    
}

<?php

/**
 * Description of dmBehaviorFrameworkPluginConfiguration
 *
 * @author TheCelavi
 */
class dmBehaviorFrameworkPluginConfiguration extends sfPluginConfiguration {
    
    public function initialize() {
        $this->dispatcher->connect('dm.service_container.configuration', array($this, 'listenToServiceContainerConfiguration'));
        $this->dispatcher->connect('dm.layout.filter_stylesheets', array($this, 'listenToFilterStylesheet'));
        $this->dispatcher->connect('dm.layout.filter_javascripts', array($this, 'listenToFilterJavascript'));
    }
    
    public function listenToServiceContainerConfiguration(sfEvent $e) {        
        if (dmContext::getInstance()->getConfiguration()->getApplication() == 'admin') return;            
        $e['container']->offsetSet('tool_bar_view.class', 'dmBehaviorFrameworkFrontToolBarView');
        $e['container']->offsetSet('page_helper.class', 'dmBehaviorableFrontPageBaseHelper');
        $e['container']->offsetSet('page_helper.edit_class', 'dmBehaviorableFrontPageEditHelper');
        $e['container']->offsetSet('page_helper.view_class', 'dmBehaviorableFrontPageViewHelper');
    }
    
    public function listenToFilterStylesheet(sfEvent $e) {
        $context = dmContext::getInstance();        
        $response = $context->getResponse();
        if ($context->getConfiguration()->getApplication() == 'admin') return $response->getStylesheets();
        if (dmContext::getInstance()->getUser()->can('widget_edit')) {            
            $response->addStylesheet('/dmBehaviorFrameworkPlugin/css/dmBehaviorFramework.css');
        }        
        foreach ($css = dmBehaviorsManager::getInstance()->getStylesheets() as $c) $response->addStylesheet($c);
        return $response->getStylesheets();
    }
    
    public function listenToFilterJavascript(sfEvent $e) {
        $context = dmContext::getInstance();
        $response = $context->getResponse();
        if ($context->getConfiguration()->getApplication() == 'admin') return $response->getJavascripts();        
        if ($context->getUser()->can('widget_edit')) {            
            $response->addJavascript('/dmCorePlugin/lib/maxzindex/jquery.maxzindex.js');
            $response->addJavascript('/dmBehaviorFrameworkPlugin/js/dmBehaviorFramework.js');
        }        
        foreach ($js = dmBehaviorsManager::getInstance()->getJavascripts() as $j) $response->addJavascript($j);
        return $response->getJavascripts();
    }
}

?>

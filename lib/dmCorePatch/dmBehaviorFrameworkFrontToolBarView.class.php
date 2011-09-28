<?php
/**
 * Description of dmBehaviorFrameworkFrontToolBarView
 *
 * @author TheCelavi
 */
class dmBehaviorFrameworkFrontToolBarView extends dmFrontToolBarView {
    
    public function render() {
        return
        $this->helper->open('div#dm_tool_bar.dm.clearfix.' . sfConfig::get('dm_toolBar_flavour', 'blue')) .
        $this->renderClearCache() .
        $this->renderCodeEditor() .
        $this->renderCultureSelect() .
        $this->renderThemeSelect() .
        $this->renderPageAdd() .
        $this->renderPageEdit() .        
        $this->renderShowPageStructure() .
        $this->renderWidgetAdd() .
        $this->renderBehaviorEdit() .
        $this->renderGoToAdmin() .
        $this->renderUserLinks() .
        $this->renderSfWebDebug() .
        $this->helper->close('div');
    }
    
    protected function renderBehaviorEdit() { 
        
        if (dmContext::getInstance()->getUser()->can('widget_edit')) {
        return 
        
        '<div class="dm_menu">
        <ul class="ui-helper-reset level0">
            <li class="first last ui-state-default">
                <a id="dm_add_behavior" class="tipable ui-corner-bottom dm_add_behavior" title="'.$this->i18n->__('Add behavior to widget').'">
                    <img src="/dmBehaviorFrameworkPlugin/images/gear.png" />
                </a>
            </li>
        </ul>
        </div>'
         . dmBehaviorsManager::getInstance()->renderBehaviorsToolbar();
        } else return '';
    }
    
    
    
}

?>

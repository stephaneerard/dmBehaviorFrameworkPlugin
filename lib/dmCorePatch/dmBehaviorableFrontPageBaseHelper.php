<?php

abstract class dmBehaviorableFrontPageBaseHelper extends dmFrontPageBaseHelper
{

	public function renderWidget(array $widget)
	{
		$this->executeWidgetAction($widget);
		 
		list($widgetWrapClass, $widgetInnerClass) = $this->getWidgetContainerClasses($widget);

		/*
		 * Open widget wrap with wrapped user's classes
		 */
                
                // CHECK IF IS BEHAVIORABLE
                
                
                $behaviorSettings = $this->getBehaviorsFromWidget($widget);
                
		$html = '<div class="'.$widgetWrapClass.'">';

		/*
		 * Open widget inner with user's classes
		 */
		$html .= '<div class="'.$widgetInnerClass . (($behaviorSettings) ? " behaviorable ".str_replace('"', "'", json_encode($behaviorSettings)) : "").'">';

		/*
		 * get widget inner content
		 */
		$html .= $this->renderWidgetInner($widget);

		/*
		 * Close widget inner
		 */
		$html .= '</div>';

		/*
		 * Close widget wrap
		 */
		$html .= '</div>';
		return $html;
	}
        
        protected function getBehaviorsFromWidget(array $widget) {
            return dmBehaviorsManager::getInstance()->registerBehaviors($widget['value']);
        }
}
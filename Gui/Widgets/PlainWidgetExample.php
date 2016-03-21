<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ManiaLivePlugins\pluginAcme\Gui\Widgets;

/**
 * Description of PlainWidgetExample
 *
 * @author Petri Järvisalo <petri.jarvisalo@gmail.com>
 */
class PlainWidgetExample extends \ManiaLivePlugins\eXpansion\Gui\Widgets\PlainWidget
{
    protected $script;
    protected $count = 3;

    protected function onConstruct()
    {
        parent::onConstruct();
        
        $this->script = new \ManiaLivePlugins\eXpansion\Gui\Structures\Script("libraries/ManialivePlugins/pluginAcme/Gui/Script", true);
        $this->registerScript($this->script);

        for ($x = 1; $x <= $this->count; $x++) {
            $quad = new \ManiaLib\Gui\Elements\Quad(6, 6);
            $quad->setId("ball".$x);
            $quad->setStyle("ManiaPlanetLogos");
            $quad->setSubStyle("IconPlanets");
            $this->addComponent($quad);
        }           
    }
}
<?php

namespace ManiaLivePlugins\pluginAcme\Gui\Widgets;

/**
 * Description of acmeWidget
 *
 * @author Petri Järvisalo <petri.jarvisalo@gmail.com>
 */
class acmeWidget extends \ManiaLivePlugins\eXpansion\Gui\Widgets\Widget
{
    protected $titlebar;
    protected $button, $button2, $button3;

    protected function exp_onBeginConstruct()
    {
        $this->setName("acmeWidget");
        $this->titlebar = new \ManiaLivePlugins\eXpansion\Gui\Elements\WidgetTitle(60, 20);
        $this->titlebar->setText(exp_getMessage("acmePlugin actions"));
        $this->titlebar->setDirection("top"); // can be top, left or right
        $this->addComponent($this->titlebar);

        $this->button = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button->setPosition(3, -8);
        $this->button->setAction($this->createAction(array($this, "open"), "window"));
        $this->button->setText("such Windows");
        $this->addComponent($this->button);

        $this->button2 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button2->setPosition(3, -16);
        $this->button2->colorize("0f0");
        $this->button2->setAction($this->createAction(array($this, "open"), "fun on"));
        $this->button2->setText("much fun");
        $this->addComponent($this->button2);

        $this->button3 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button3->setPosition(30, -16);
        $this->button3->colorize("f00");
        $this->button3->setAction($this->createAction(array($this, "open"), "fun off"));
        $this->button3->setText("less fun");
        $this->addComponent($this->button3);
    }

    protected function exp_onEndConstruct()
    {
        $this->setSize(60, 20);
        $this->titlebar->setSize($this->getSizeX(), $this->getSizeY());
    }

    public function onResize($oldX, $oldY)
    {

        parent::onResize($oldX, $oldY);
    }

    public function open($login, $params)
    {
        switch ($params) {
            case "fun on":
                $win = \ManiaLivePlugins\pluginAcme\Gui\Widgets\PlainWidgetExample::create($login);
                $win->show();
                break;
            case "fun off":
                \ManiaLivePlugins\pluginAcme\Gui\Widgets\PlainWidgetExample::Erase($login);
                break;
            case "window":
            default:
                $win = \ManiaLivePlugins\pluginAcme\Gui\Windows\ExampleWindow::create($login);
                $win->show();
                break;
        }
    }
}
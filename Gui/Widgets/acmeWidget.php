<?php

namespace ManiaLivePlugins\pluginAcme\Gui\Widgets;

/**
 * Description of acmeWidget
 *
 * This is a small widget to do some usless stuff on the server.
 *
 * @author Petri Järvisalo <petri.jarvisalo@gmail.com>
 */
class acmeWidget extends \ManiaLivePlugins\eXpansion\Gui\Widgets\Widget
{
    /*
     * We might need the refrences to all the items we display, this will allow us to change their position... if needed
     */
    protected $titlebar;
    protected $button, $button2, $button3;

    protected function exp_onBeginConstruct()
    {
        /**
         * Let's first give a name to our widget. This name need to be unique. It is going to be used to store player
         * configurations on this widget in their persisten variables.
         *
         * It is also going to be used to preload some settings. We will discuss about this at another place.
         *
         * Finally it is going yo be used in the ingame debug window when you click CTRL+G
         */
        $this->setName("acmeWidget");

        /**
         * We are going to use an element created for eXpansion windows to use as title on our widget.
         * An element is basically a group of labels & quads.
         *
         * This element takes in parameter it's size to generate properly the background and...
         */
        $this->titlebar = new \ManiaLivePlugins\eXpansion\Gui\Elements\WidgetTitle(60, 20);
        /**
         * Here we set the title of the title bar.
         *
         * Note that we are not passing a string but the translation object in parameter. The Gui handler will use this
         * to create the proper content so that the game might translate it to the players that will receive this plugin.
         */
        $this->titlebar->setText(exp_getMessage("acmePlugin actions"));
        $this->titlebar->setDirection("top"); // can be top, left or right
        /**
         * Finally we add the title bar inside our widget. Note that we didnt set it's position. This element will
         * automatically calculate it.
         */
        $this->addComponent($this->titlebar);

        /**
         * Now we are going to create a button and will put some actions on to this button. We are using an
         * eXpanion Element again. This will create a button with proper background and borders.
         */
        $this->button = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        /**
         * We position the button. relative to the position of the windows.
         */
        $this->button->setPosition(3, -8);
        /**
         * We add an action to the button. The action will call the open function of this object thanks to the callback
         * array($this, 'open'). The action will also send a parameter with the information "window" to the method
         * when it is called. (we can put here an array or an object anything).
         */
        $this->button->setAction($this->createAction(array($this, "open"), "window"));
        // Adding a simple text to the button.
        $this->button->setText("such Windows");
        // Finally add the button to the current window.
        $this->addComponent($this->button);

        /**
         * We will create a second button, which has a special color.
         */
        $this->button2 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button2->setPosition(3, -16);
        // We are going to colorize this button to green instead of the default color.
        $this->button2->colorize("0f0");
        $this->button2->setAction($this->createAction(array($this, "open"), "fun on"));
        $this->button2->setText("much fun");
        $this->addComponent($this->button2);

        /**
         * Finally create a red button.
         */
        $this->button3 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button3->setPosition(30, -16);
        $this->button3->colorize("f00");
        $this->button3->setAction($this->createAction(array($this, "open"), "fun off"));
        $this->button3->setText("less fun");
        $this->addComponent($this->button3);
    }

    protected function exp_onEndConstruct()
    {

        /**
         * Doing the construction of any widget the size of the widget might change. This is due to the loading of the
         * sizes & positions of the widget. This allows admins to relocate & resize any widget. But this also means that
         * when you create the content you don't have the proper sizes.
         *
         * So now the size is ready let set up the size of our title bar.
         */

        // We have not created default configurations for this widget so it going to fail, we will therefore force a size.
        $this->setSize(60, 20);

        // And be sure the title bar has proper size.
        $this->titlebar->setSize($this->getSizeX(), $this->getSizeY());
    }

    public function onResize($oldX, $oldY)
    {
        /**
         * Everytime a window is resized this funstion is called so that you might change the size & position of the
         * elements inside the window. We could/should have changed the size of the titlebar here.
         */

        // Be sure to call the parent so that default systems work.
        parent::onResize($oldX, $oldY);
    }

    /**
     * This is our method that is called when a user clicks on one of the buttons. We could have called 3 diffrent
     * methods but right now we wish to see how params work.
     *
     * @param string $login We always receive the login of the user that has interacted with the action.
     * @param mixed $params And we receive the value set when we created the action.
     */
    public function open($login, $params)
    {
        switch ($params) {
            case "fun on":
                /**
                 * If the user has clicked on fun on we are going to display to that user yet another widget. Again we
                 * are using the static method create to create a widget for a certain player.
                 *
                 * What happens if the user clicks on fun on 2 times? well by default any widget/window can only
                 * be displayed once. If you wish to display the same widget 2 times you need to call it with singleton
                 * false :
                 *  create($login, false);
                 *
                 * Using the static Erease method will then erease all instances of the window. If you wish to delete
                 * a single instance you will need to keep the object refrence and call $win->erease
                 */
                $win = \ManiaLivePlugins\pluginAcme\Gui\Widgets\PlainWidgetExample::create($login);
                $win->show();
                break;
            case "fun off":
                /**
                 * If the user has clicked on fun off we are going to remove, erease will delete all instances of this
                 * widget sent to this player. So if we sent the widget 2 times it will delete both widgets.
                 */
                \ManiaLivePlugins\pluginAcme\Gui\Widgets\PlainWidgetExample::Erase($login);
                break;
            case "window":
            default:
                /**
                 * And last we will create a window if the user asks for one. The logic is identical to widgets.
                 */
                $win = \ManiaLivePlugins\pluginAcme\Gui\Windows\ExampleWindow::create($login);
                $win->show();
                break;
        }
    }
}
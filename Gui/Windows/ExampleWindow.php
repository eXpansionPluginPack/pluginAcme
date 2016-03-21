<?php

namespace ManiaLivePlugins\pluginAcme\Gui\Windows;

/**
 * This is a example to create an window
 *
 * @author Petri Järvisalo <petri.jarvisalo@gmail.com>
 */
class ExampleWindow extends \ManiaLivePlugins\eXpansion\Gui\Windows\Window
{
    /*
     * windowing system works all with php, it's important to register all properties with protected or public
     * othervice the memory consumption will rise over time.
     */
    protected $frame;
    protected $label;
    protected $button1, $button2;
    protected $langLabel, $dicoLabel;
    protected $inputbox;

    /*
     * this will create the window
     */

    protected function onConstruct()
    {
        /* very important is to call this parent constructor at the first line, othervice window will not work */
        parent::onConstruct();

        /* this will set the window name and title */
        $this->setTitle("Example Window");
        /* set the size */
        $this->setSize(160, 90);

        /* you can define the window layer too, it can be normal, scoreboard, or others defined at self::layer_
         * scoresboard will be displayed when you press tab
         */
        $this->setLayer(self::LAYER_NORMAL);

        /* there are only few basic manialive gui elements that we use and they are:
         * frame, a group container which can have layout defined
         * label, an element which holds simply text
         * quad, an element used to contain images
         */

        $this->frame = new \ManiaLive\Gui\Controls\Frame(0, 0, new \ManiaLib\Gui\Layouts\Column(20, 20)); // let's make frame that stacks elements a column
        $this->addComponent($this->frame);

        $this->label = new \ManiaLib\Gui\Elements\Label(90, 16);
        $this->label->setText("Here is an example");
        $this->label->setTextColor("3af");

        /**
         * for styles, see ingame manialink: styles
         * @see maniaplanet://styles */
        $this->label->setStyle("TextRaceMessageBig");
        $this->frame->addComponent($this->label);

        /** multilingual support can be done using DicoLabel or using our __() function.         */
        $this->langLabel = new \ManiaLib\Gui\Elements\Label(90, 6);
        $this->langLabel->setText(__("Say hello by entering value", $this->getRecipient()));
        $this->frame->addComponent($this->langLabel);

        /* dicolabel is inherited from label, but it takes \ManiaLivePlugins\eXpansion\Core\i18n\Message as parameter */
        $this->dicoLabel = new \ManiaLivePlugins\eXpansion\Gui\Elements\DicoLabel(90, 16);
        $this->dicoLabel->setStyle("TextRaceMessageBig");
        $this->frame->addComponent($this->dicoLabel);

        /* to make grahpical inputbox */
        $this->inputbox = new \ManiaLivePlugins\eXpansion\Gui\Elements\Inputbox();
        $this->inputbox->setName("toWho");
        $this->inputbox->setLabel("enter value:");
        $this->inputbox->setText("maniaplanet");
        $this->frame->addComponent($this->inputbox);

        $this->button1 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        /* to have clickable object, we set action. */
        $this->button1->setAction($this->createAction(array($this, "ok")));
        $this->button1->setText("say hello");
        $this->frame->addComponent($this->button1);

        /* finally we make close button to demonstrate close by action id */
        $this->button2 = new \ManiaLivePlugins\eXpansion\Gui\Elements\Button();
        $this->button2->colorize("f00");
        $this->button2->setAction($this->createAction(array($this, "closeMe")));
        $this->button2->setText(__("close", $this->getRecipient()));
        $this->frame->addComponent($this->button2);
    }

    /**
     * callback function from create action
     *
     * @param string $login who clicked the action id
     * @param array $entries will be keyed array of inputboxes
     */
    function Ok($login, $entries)
    {
        // set new message to salute
        $this->dicoLabel->setText(exp_getMessage('Hello %1$s'), array($entries["toWho"]));

        // set inputbox with same value as you typed, you could reset it here by entering empty value
        $this->inputbox->setText($entries["toWho"]);

        // finally redraw window
        $this->redraw();
    }

    function closeMe($login) {
        $this->closeWindow();
    }

}
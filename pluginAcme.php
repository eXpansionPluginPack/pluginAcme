<?php

namespace ManiaLivePlugins\pluginAcme;

use ManiaLivePlugins\eXpansion\Core\types\BasicPlugin;

/**
 * This is a development plugin to learn how to create plugins for expansion.
 *
 * @see https://github.com/eXpansionPluginPack/eXpansion/wiki/Developpers-:-First%20plugin
 *
 * Class Acme
 * @package ManiaLivePlugins\eXpansion\Acme
 */
class pluginAcme extends BasicPlugin
{
    /**
     * @var Config
     */
    private $config;

    /**
     * This method is called when the plugin is first initialized. Very early in the loading process.
     */
    public function exp_onInit()
    {
        // Define a version : This is will be displayed to the user in the plugin list.
        $this->setVersion('0.1.0');

        // Get the configuration object. You might as well get it whanever you need it.
        $this->config = Config::getInstance();
    }

    /**
     * Once the plugin initialized it will be loaded. This plugin is ready but other plugins might not be.
     */
    public function exp_onLoad()
    {
    }

    /**
     * Once all plugins are loaded and the system is ready.
     */
    public function exp_onReady()
    {
        // When all is ready we can register a chat command :

        /**
         * The command the user will need to use is /hello, it will call the sayHello method of this class.
         *
         * The command can take an unlimited amount of parameters(0 will mean no parameters,
         * 1 that it needs one parameter ...)
         *
         * And finally the login of the user that used the command will be sent to the method.
         *
         * @see sayHello
         */

        $this->registerChatCommand('hello_acme', "sayHello", -1, true);

        $widget = Gui\Widgets\acmeWidget::Create();
        $widget->setPosition(0,70);
        $widget->setLayer("scoresboard");
        $widget->show();
        
    }

    /**
     * Method call when an user uses the hello chat command.
     *
     * @param string $login
     *   The login of the user that used the command.
     *
     * @param string $params
     *   All the parameters passed to the hello command. for hello toto tata we will have 'toto tata' string)
     */
    public function sayHello($login, $params = "") {

        // The user might wish to say hello to everyone, and not one person.
        if (empty($params)) {

            /**
             * We will send the message to everyone, so to null. But this won't work well with translations. The method
             * will search for translations but the string here is dynamic and might change
             * depending on the configuration.
             */
            // $this->exp_chatSendServerMessage('Hello ' . $this->config->who, null);

            /**
             * That is why we will use this method to send the chat. Here we are using one string with a "token" (%1$s)
             * which means the first element in the array will replace it. So the end text will be "Hello world" but
             * when being translated it will try to translate "Hello %1$s". That will be translated in french as
             * "Bonjour %1$s" and when the token is processes it will become "Bonjour world".
             *
             * @see https://github.com/eXpansionPluginPack/eXpansion/wiki/Developpers-:-i18n-support
             */
            $this->exp_chatSendServerMessage('Hello %1$s', null, array($this->config->who));

        } else {

            // Break the params into multiple parts.
            $args = explode(' ', $params);

            // We are sending one message to each player
            foreach ($args as $playerLogin) {
                // Check if the player exists.
                $player = $this->storage->getPlayerObject($playerLogin);

                if (!is_null($player)) {
                    /**
                     * The player exist. We will use the same method as before. But this time we send it to the player
                     * so not to "null" and we use the player nickname instead of the configuration value.
                     */
                    $this->exp_chatSendServerMessage('Hello %1$s', $playerLogin, array($player->nickName));

                } else {
                    /**
                     * The player can't be found, we need to send an error to the user that used the chat command.
                     * Have you noticed how dull our messages has been? So this code will work it won't look nice.
                     * We need to add some color.
                     */
                    //$this->exp_chatSendServerMessage('Player %1$s isn\'t on the server. Can\'t say hello', $login, array($playerLogin));

                    /**
                     * For that we won't use color codes but some different tokens, that starts and end with #
                     * We are using #error# which is basically red text & #variable# that is white to differentiate the
                     * login of the non existing player.
                     *
                     * All color codes are defined here :
                     * @see ManiaLivePlugins\eXpansion\Core\Config
                     * They are prefixed by Colors_ and can be configured in game. Check the wiki for more information :
                     * @see https://github.com/eXpansionPluginPack/eXpansion/wiki/Developpers-:-Chat-Colors
                     */
                    $this->exp_chatSendServerMessage('#error#Player #variable#%1$s #error#isn\'t on the server. Can\'t say hello', $login, array($playerLogin));
                }
            }
        }

    }

    /**
     * When the plugin is uninstalled. It is important to destroy all windows that the plugin might have opened
     * when it was running in order to handle memory. Keep in mind that plugins can be started & stopped quite often
     * and it the most abvious place for memory leaks.
     *
     * Some eXpansion plugins don't do it properly because they are part of the core and can't be unloaded anyway.
     */
    public function exp_onUnload()
    {
        Gui\Widgets\acmeWidget::EraseAll();

    }

}

?>
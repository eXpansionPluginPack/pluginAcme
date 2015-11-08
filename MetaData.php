<?php

namespace ManiaLivePlugins\eXpansion\Acme;


use ManiaLivePlugins\eXpansion\Core\types\config\types\String;

/**
 * Description of MetaData
 *
 * @author De Cramer Oliver
 */
class MetaData extends \ManiaLivePlugins\eXpansion\Core\types\config\MetaData
{

	public function onBeginLoad()
	{
		parent::onBeginLoad();

		$this->setName("eXpansion Acme");
		$this->setDescription("A demo plugin to show dev's how to create plugins");
		$this->setGroups(array('Demo'));

		// Get configuration instance,
		$config = Config::getInstance();

		/* Create a new variable. "who" is the name of the variable in the config class, and the second parameter
		 * the name to display in the front.
		 */
		$var = new String("who", "Who do we great hello to?", $config);
		// Description of this variable. We use a dummy description.
		$var->setDescription("Dummy description");
		// Default value used to reset the setting.
		$var->setDefaultValue('world');

		// We register the variable to enable configuration in game.
		$this->registerVariable($var);
	}
}

?>

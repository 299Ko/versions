<?php

logg("Began of _afterChangeFiles", "INFO");

// After blog change config file
pluginsManager::getInstance()->installPlugin('blog', true);

logg("End of _afterChangeFiles", "INFO");
return true;
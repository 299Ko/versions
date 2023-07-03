<?php

logg("Began of _afterChangeFiles", "INFO");

$blogConfig = util::readJsonFile(DATA_PLUGIN . 'blog/config.json');

$blogConfig["authorName"] = "";
$blogConfig["authorAvatar"] = "";
$blogConfig["authorBio"] = "";
$blogConfig["displayAuthor"] = false;

if (util::writeJsonFile(DATA_PLUGIN . 'blog/config.json', $blogConfig)) {
    logg("Blog Config changed for Author", "INFO");
} else {
    logg("Unable to modify blog config", "ERROR");
}

logg("End of _afterChangeFiles", "INFO");


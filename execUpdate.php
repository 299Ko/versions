<?php

/**
 * @copyright (C) 2022, 299Ko, based on code (2010-2021) 99ko https://github.com/99kocms/
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Jonathan Coulet <j.coulet@gmail.com>
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * @author Frédéric Kaplon <frederic.kaplon@me.com>
 * @author Florent Fortat <florent.fortat@maxgun.fr>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */

// need to be started in CLI, in versions folder
// php execUpdate.php

define('KOPATH', '../299ko/');
define('VERSIONSPATH', '../versions/');

$version = '2.0.0';
$commitLastVersion =   'ac061f240360e5d22b41a236768628cf143e9821';
$commitFutureVersion = 'aa4cae7fe115aebf8a17b3e6a6bfc325c1f0f2fd';

chdir(KOPATH);

$result = null;
exec('git diff --name-status ' . $commitLastVersion . ' ' . $commitFutureVersion, $result);

chdir(VERSIONSPATH);

$json = [];

foreach ($result as $r) {
    $line = explode("\t", $r);
    if (count($line) === 2) {
        $json[$line[0]][] = $line[1];
    } elseif (count($line) === 3) {
        if (substr($line[0],0,1) === "R") {
            // Rename detected
            $json["D"][] = $line[1];
            $json["A"][] = $line[2];
        }
    }
}

if (!is_dir('core/' . $version)) {
    mkdir('core/' . $version, 0777, true);
}

file_put_contents('core/' . $version . '/files.json', json_encode($json, true));


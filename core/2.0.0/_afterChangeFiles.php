<?php

logg("Began of _afterChangeFiles", "INFO");

pluginsManager::getInstance()->installPlugin('users', true);

$mail = core::getInstance()->getConfigVal('adminEmail');
$pwd = core::getInstance()->getConfigVal('adminPwd');
$token = $_SESSION['adminToken'];

$users = [ 1 => [
    'id'=> 1,
    'email' => $mail,
	'token' => $token,
	'pwd' => $pwd]
];

logg("Create Admin User", "INFO");
util::writeJsonFile(DATA_PLUGIN . 'users/users.json', $users);
$config = util::readJsonFile(DATA . 'config.json');
unset($config['adminEmail']);
unset($config['adminPwd']);
logg("Delete User in config", "INFO");
util::writeJsonFile(DATA . 'config.json', $config);

logg("Modif Blog comments", "INFO");
$newsManager = new newsManager();
$datas = util::scanDir(DATA_PLUGIN . 'blog/comments/');
foreach ($datas['file'] as $file) {
    logg("Read & export comments from $file", "INFO");
    $comments = util::readJsonFile(DATA_PLUGIN . 'blog/comments/' . $file);
    if (!empty($comments)) {
        foreach ($comments as $comm) {
            $idNews = $comm['idNews'];
            $item = $newsManager->create($idNews);
            $newsManager->loadComments($idNews);
            $comment = new newsComment();
            $comment->setIdNews($idNews);
            $comment->setAuthor($comm['author']);
            $comment->setAuthorEmail($comm['authorEmail']);
            $comment->setAuthorWebsite('');
            $comment->setDate($comm['date']);
            $comment->setContent($comm['content']);
            $newsManager->saveComment($comment);
        }
    }
    unlink($file);
}
rmdir(DATA . 'blog/comments');

logg("Change contact Email", "INFO");
$contact = pluginsManager::getInstance()->getPlugin('contact');
$contact->setConfigVal('userMailId', 1);
pluginsManager::getInstance()->savePluginConfig($contact);
        
logg("End of _afterChangeFiles", "INFO");
return true;
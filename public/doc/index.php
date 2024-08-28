<?php

use SimpleScribe\Doc;

spl_autoload_register(function ($class) {
    if (!str_starts_with($class, 'SimpleScribe')) {
        return;
    }
    require_once __DIR__ . '/'.str_replace('SimpleScribe\\', '', $class).'.php';
});

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 'on');

?>

<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <title>Документация API</title>
    <link href="front/bootstrap.css" rel="stylesheet" >
    <link rel="stylesheet" href="front/style.css" type="text/css" media="all"/>
</head><body>

<?php
try {
    $doc = new Doc();
    $data = $doc->scanAllComments();
    $doc->addRoutesInfo($data);
} catch (\Exception $e) {
    ?>
    <div class="alert alert-danger"><?=$e->getMessage()?></div>
    <?php
    return;
}
?>

<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #e3f2fd;" data-bs-theme="light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">API</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($data as $groupName => $methods) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#<?=$groupName?>"><?=$groupName?></a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Показать все</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div><br><br><br></div>


<div class="container-fluid" id="doc-app" data-groups='<?=json_encode($data)?>'>
    <div v-for="(methods, groupName) in groups">
        <h3 :data-group="groupName">{{ groupName }}</h3>
        <div class="group">
            <div v-for="(info, method) in methods" class="method-block">
                <block-main :info="info" :method="method"></block-main>
                <div class="block__info block__hidden">
                    <div class="row">
                        <div class="col">
                            <block-params :info="info"></block-params>
                        </div>
                        <div class="col">
                            <block-try v-if="info.requestMethod == 'POST'" :info="info"></block-try>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" src="front/index.js"></script>

</body></html>
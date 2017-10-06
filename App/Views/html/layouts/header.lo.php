<?php
function buildPageOptions($page,$app_http) {
    $html = '';
    if ($page->getOptions()) {
        $size = sizeof($page->getOptions());
        $navWidth = 15*$size;
        $btnWidth = $navWidth/($size*.8);
        $html .= "  <div style=\"width:{$navWidth}%\" class=\"inline-block navigation subNav\">";
        foreach ($page->getOptions() as $subnav) {
            $isCurrent = (isset($data['action']) && isset($subnav['action']) && $subnav['action'] == $data['action']) || (!isset($data['action']) && !isset($subnav['action']));
            $html .= "<a style=\"width:{$btnWidth}%\" class=\"capitalize".($isCurrent ? ' current':'').(isset($subnav['modal']) ? ' do-loadmodal':'')."\" href=\"{$app_http}".((isset($subnav['action'])) ? "?action={$subnav['action']}":'')."\">{$subnav['name']}</a>";
        }
        $html .= '  </div>';
    }
    return $html;
}

function buildPrimaryNavigation($pages,$controllerName,$path_http,$globalUser) {
    $html = '<div class="navigation">';
    if ($globalUser->isLoggedIn()) {
        foreach ($pages as $controllerKey=>$nav) {
            if (!$nav->isAdminPage() || ($nav->isAdminPage() && $globalUser->isAdmin())) {
                $html .= "<a class=\"capitalize".(($controllerKey == $controllerName) ? ' current':'')."\" href=\"{$path_http}{$nav->getPath()}/\">{$nav->getName()}</a>";
            }
        }
    }
    return $html.'</div>';
}

function buildSearchForm($page,$app_http) {
    $html = '';
    if ($page->isSearchable()) {
        $html .= '  <form id="doSearch" class="do-get inline-block" name="search" method="POST" action="'.$app_http.'">
                    <input type="hidden" name="action" value="search" />
                    <input id="searchTerm" class="inline" type="text" name="term" />';
        $html .= '      <input id="searchResults" class="inline" type="submit" name="submit" value="Search" />
                    <div class="inline-block" id="searchStatus">
                        <a class="hidden" href="#clearSearch">clear search</a>
                    </div>
                </form>';
    }
    return $html;
}

function buildSystemMessages($systemMessages=null) {
    $html = '  <div class="sysMsg">';
    if ($systemMessages) {
        foreach ($systemMessages as $sysMsg) {
            $html .= "    <h4 class=\"alert\">{$sysMsg->getMessage()}</h4>";
        }
    }
    return $html .'</div>';
}

function buildUserDashboard($globalUser,$path_http) {
    $html = '';
    if ($globalUser->isLoggedIn()) {
        $html .= '  <div style="float:right;min-width: 5%;padding:12px 20px;">Hi <a href="'.$path_http.'user.php?action=edit">'.$globalUser->getProfileValue('username').'</a>! (<a href="'.$path_http.'user.php?action=logout">logout</a>)</div>';
    }
    return $html;
}


function buildPageHeader($page,$app_http) {
    $html = '';
    if (!empty($page)) {
        if ($page->getTitle()) {
            $html .= "
                <h1>{$page->getTitle()}</h1>";
        }
        $html .= '<div>';
        $html .= buildPageOptions($page,$app_http);
        $html .= buildSearchForm($page,$app_http);
        $html .= '</div>';
    }
    $html .= '        <div id="modalContent">';
    if (!empty($page) && $page->getSubtitle()) {
        $html .= "     <h4 class=\"capitalize\">{$page->getSubtitle()}</h4>";
    }
    return $html;
}

$themeFolder = 'html';
$themePath = $config['PATH_THEMES'].$themeFolder.'/';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo APP_NAME;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />

        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <link rel="apple-touch-icon" href="iphone-icon.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_CSS'];?>helpers.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $themePath;?>css/style.css" media="screen"/>
<?php
if (is_file("{$config['PATH_APP']}site/resources/themes/{$themeFolder}/css/{$controllerName}.css")) {
    echo '<link rel="stylesheet" type="text/css" href="'.$themePath.'css/'.$controllerName.'.css" media="screen"/>';
}
?>
        <link rel="stylesheet" href="<?php echo $config['PATH_JS'];?>vendor/jquery-ui-1.11.2.custom/jquery-ui.css">
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>vendor/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>vendor/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
        <script type="text/javascript">
            var app_http = '<?php echo $app_http;?>';
        </script>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>pipit.functions.js"></script>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>pipit.listeners.js"></script>
        <script type="text/javascript" src="<?php echo $themePath;?>js/theme.js"></script>
<?php
if ($controllerName != 'default' && is_file("{$config['PATH_APP']}site/resources/js/{$controllerName}.js")) {
    echo '
        <script type="text/javascript" src="'.$config['PATH_JS'].$controllerName.'.js"></script>';
}
?>
        <link rel="shortcut icon" href="ico/favicon.ico">
    </head>
    <body>
        <div id="theOverlay"></div>
        <div id="theModal">
            <div class="header">
                <div class="loader">
                    <div id="squaresWaveG">
                        <div id="squaresWaveG_1" class="squaresWaveG"></div>
                        <div id="squaresWaveG_2" class="squaresWaveG"></div>
                        <div id="squaresWaveG_3" class="squaresWaveG"></div>
                        <div id="squaresWaveG_4" class="squaresWaveG"></div>
                        <div id="squaresWaveG_5" class="squaresWaveG"></div>
                        <div id="squaresWaveG_6" class="squaresWaveG"></div>
                        <div id="squaresWaveG_7" class="squaresWaveG"></div>
                        <div id="squaresWaveG_8" class="squaresWaveG"></div>
                    </div>
                </div>
                <a class="do-close" href="#">Close</a>
            </div>
            <div class="content">
            </div>
        </div>
        <header>
            <h1><?php echo $config["APP_NAME"];?></h1>
        </header>

<?php
echo buildPrimaryNavigation($pages,$controllerName,$config['PATH_HTTP'],$globalUser);
?>
        <div id="systemBar">
<?php
echo buildUserDashboard($globalUser,$config['PATH_HTTP']);
echo buildSystemMessages($systemMessages);
?>
        </div>
        <div class="container">
<?php
echo buildPageHeader($page,$app_http);
?>

<?php
function buildPageOptions($page,$app_http) {
    $html = '';
    if ($page->getOptions()) {
        $html .= "  <div class=\"col col-sm-8\">
                    <ul class=\"nav nav-pills\">";
        foreach ($page->getOptions() as $subnav) {
            $isCurrent = (isset($data['action']) && isset($subnav['action']) && $subnav['action'] == $data['action']) || (!isset($data['action']) && !isset($subnav['action']));
            $html .= "      <li".(($isCurrent) ? ' class="active"':'').">
                            <a class=\"capitalize".(isset($subnav['modal']) ? ' do-loadmodal':'')."\" href=\"{$app_http}".((isset($subnav['action'])) ? "?action={$subnav['action']}":'')."\">{$subnav['name']}</a>
                        </li>";
        }
        $html .= '      </ul>
                </div>';
    }
    return $html;
}

function buildPrimaryNavigation($pages,$controllerName,$path_http,$globalUser) {
    $html = '';
    if ($globalUser->isLoggedIn()) {
        foreach ($pages as $controllerKey=>$sitePage) {
            $html .= '          <li'.(($controllerKey == $controllerName) ? ' class="active"':'').'>';
            if (!$sitePage->isAdminPage() || ($sitePage->isAdminPage() && $globalUser->isAdmin())) {
                $html .= "<a class=\"capitalize\" href=\"{$path_http}{$sitePage->getPath()}/\">{$sitePage->getName()}</a>";
            }
            $html .= '          </li>';
        }
    }
    return $html;
}

function buildSearchForm($page,$app_http) {
    $html = '';
    if ($page->isSearchable()) {
        $html .= '<div class="col col-sm-4">
                    <form id="doSearch" class="do-get" name="search" method="POST" action="'.$app_http.'">
                        <input type="hidden" name="action" value="search" />
                        <div class="input-group">
                            <input id="searchTerm" class="form-control" type="text" name="term" />';
        $html .= '              <span class="input-group-btn">
                                <input id="searchResults" class="btn btn-default" type="submit" name="submit" value="Search" />
                            </span>
                        </div>
                        <div class="inline-block" id="searchStatus">
                            <a class="hidden" href="#clearSearch">clear search</a>
                        </div>
                    </form>
                </div>';
    }
    return $html;
}

function buildSystemMessages($systemMessages=null) {
    $html = '<div class="sysMsg col-sm-10">';
    if ($systemMessages) {
        foreach ($systemMessages as $sysMsg) {
            $typeMap = array('error'=>'danger');
            $msgType = $sysMsg->getType();
            if (array_key_exists($msgType,$typeMap)) {
                $msgType = $typeMap[$msgType];
            }
            $html .= "  <div class=\"alert alert-{$msgType}\">{$sysMsg->getMessage()}</div>";
        }
    }
    $html .= '</div>';
    return $html;
}

function buildUserDashboard($globalUser,$path_http) {
    $html = '';
    if ($globalUser->isLoggedIn()) {
        $html .= '<div class="col-sm-2">
                    <span>Hi <a href="'.$path_http.'user.php?action=edit">'.$globalUser->getProfileValue('username').'</a>! (<a href="'.$path_http.'user.php?action=logout">logout</a>)</span>
                </div>';
    }
    return $html;
}

function buildPageHeader($page,$app_http) {
    $html = '';
    if (!empty($page)) {
        if ($page->getTitle()) {
            $html .= "
                <div class=\"page-header\">
                    <h1>{$page->getTitle()}</h1>
                </div>";
        }

        $html .= '<div id="subNav" class="row">';
        $html .= buildPageOptions($page,$app_http);
        $html .= buildSearchForm($page,$app_http);
        $html .= '</div>';
    }
    $html .= '    <div id="modalContent">';
    if (!empty($page) && $page->getSubTitle()) {
        $html .= "  <div class=\"page-header\">
                        <h1 class=\"capitalize\"><small>{$page->getSubTitle()}</small></h1>
                    </div>";
    }
    return $html;
}

$themeFolder = $config['ACTIVE_THEME'];
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

        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_THEMES'];?>tamu/css/bootstrap.min.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_THEMES'];?>tamu/css/prism.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_THEMES'];?>tamu/css/TAMUglobal.css" media="screen"/>

        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_CSS'];?>helpers.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $themePath;?>css/style.css" media="screen"/>

<?php
if (is_file("{$config['PATH_APP']}{$controllerName}.css")) {
    echo '<link rel="stylesheet" type="text/css" href="'.$config['PATH_CSS'].$controller.'.css" media="screen"/>';
}
?>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>vendor/jquery.min.js"></script>
        <!-- Bootstrap JS - Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        <script type="text/javascript">
            var app_http = '<?php echo $app_http;?>';
        </script>

        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>pipit.functions.js"></script>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>pipit.listeners.js"></script>
        <script type="text/javascript" src="<?php echo $themePath;?>js/theme.js"></script>

<?php
if ($controllerName != 'default' && is_file("{$config['PATH_APP']}site/resources/js/{$controllerName}.js")) {
    echo '<script type="text/javascript" src="'.$config['PATH_JS'].$controllerName.'.js"></script>';
}

?>
        <link rel="shortcut icon" href="ico/favicon.ico">
    </head>
    <body>
        <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
        <div id="theModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <header class="globalHeader">
            <tl-header page-title="<?php echo $config['APP_NAME'];?>" suppress-call-to-action="true">
<?php
if ($globalUser->isLoggedIn()) {
    foreach ($pages as $controllerKey => $sitePage) {
        $showNavLink = false;
        if ($sitePage->isAdminPage() && $globalUser->isAdmin()) {
            $showNavLink = true;
        } else if ($sitePage->getAccessLevel() < SECURITY_ADMIN) {
            $showNavLink = true;
        }
        if ($showNavLink) {
            echo "<wvre-nav-li href=\"{$config['PATH_HTTP']}{$sitePage->getPath()}/\">
                    <wvre-text value=\"{$sitePage->getName()}\"/>
                   </wvre-nav-li>";
        }
    }
}
?>
        </header>
        <div id="systemBar" class="clearfix">
<?php
echo buildSystemMessages($systemMessages);
echo buildUserDashboard($globalUser,$config['PATH_HTTP']);
?>
        </div>
        <div class="container clearfix">



<?php
echo buildPageHeader($page,$app_http);
?>

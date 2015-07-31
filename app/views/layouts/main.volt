<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>VGPG - ICMC - Admin</title>
    {{ stylesheet_link('/css/bootstrap.min.css') }}
    {{ stylesheet_link('/css/font-awesome.min.css') }}
    {{ assets.outputCss() }}
    {{ stylesheet_link('/css/AdminLTE.min.css') }}
    {{ stylesheet_link('/css/skin-blue.min.css') }}
    {{ stylesheet_link('/css/style.css') }}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
    <div id="flash-message">
        {{ flash.output() }}
    </div>
    <div class="wrapper">
        <!-- Navigation -->
        <header class="main-header">
            <!-- Logo -->
            {{ link_to('/', '<img class="logo-mini" src="/img/logo.png" alt="VGPG"></img><img class="logo-lg" src="/img/logo_h.png" alt="VGPG"></img>', 'class': 'logo') }}
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/img/logo.png" class="user-image" alt="User Image" />
                                <span class="hidden-xs">{{ auth.getName() }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/img/logo.png" class="img-circle" alt="User Image" />
                                    <p>
                                        {{ auth.getName() ~ ( auth.getRole() ? ' - ' ~ auth.getRole() : '') }}
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        {{ acl_link(['controller': 'user', 'action': 'change-password'], '<i class="fa fa-fw fa-key"></i> Change password', ['class': 'btn btn-default btn-flat']) }}
                                    </div>
                                    <div class="pull-right">
                                        {{ acl_link(['controller': 'session', 'action': 'logout'], '<i class="fa fa-fw fa-power-off"></i> Log Out', ['class': 'btn btn-default btn-flat']) }}
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                {{ partial('_menu') }}
            </section>
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    {% if page_title is defined %}
                        {{ _(page_title) }}
                    {% endif %}
                    {% if page_subtitle is defined %}
                        <small>{{ _(page_subtitle) }}</small>
                    {% endif %}
                </h1>
                <!-- <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Simple</li>
                </ol> -->
            </section>
            <section class="content">
                {{ content() }}
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; Visual and Geometry Processing Group 2015</strong>
        </footer>
    </div>
    {{ javascript_include('/js/jquery.js') }}
    {{ javascript_include('/js/bootstrap.min.js') }}
    {{ javascript_include('/js/app.min.js') }}
    {{ javascript_include('/js/app.js') }}
    {{ assets.outputJs() }}
    {{ assets.outputInlineJs() }}
    <script type="text/javascript">
    $(function() {
        initFlashMessage();
    });
    </script>
</body>

</html>

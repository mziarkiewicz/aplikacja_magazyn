<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>{$page_title|default:"Aplikacja wspomagająca ewidencje sprzętu"}</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{$conf->styles}main.css" />
		<noscript><link rel="stylesheet" href="{$conf->styles}noscript.css" /></noscript>
	</head>
	<body class="is-preload landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo"><a href="{$conf->action_root}">Aplikacja Ewidencja</a></h1>
					<nav id="nav">
						<ul>
							{if count($conf->roles)>0}
							<li><a href="{$conf->action_root}showMainPage">Panel główny</a></li>
							<li><a href="{$conf->action_root}itemAdd">Dodaj przedmiot</a></li>
							{/if}
							{if core\RoleUtils::inRole("admin")}
								<li><a href="#">Zarządzanie</a>
									<ul>
										<li><a href="{$conf->action_root}userAdd">Dodaj użytkownika</a></li>
										<li><a href="{$conf->action_root}showUsersPage">Zarządzaj użytkownikami</a></li>
									</ul>
								</li>
							{/if}
							{if count($conf->roles)>0}
								<li><a href="{$conf->action_root}logout" class="button">Wyloguj</a></li>
							{else}
								<li><a href="{$conf->action_root}login" class="button primary">Zaloguj</a></li>
							{/if}
						</ul>
					</nav>
				</header>

			{block name=top}{/block}

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="https://github.com/mziarkiewicz" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
						<li><a href="mailto:" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Mateusz Ziarkiewicz. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</footer>

		</div>




		<!-- Scripts -->
			<script src="{$conf->javascripts}jquery.min.js"></script>
			<script src="{$conf->javascripts}jquery.scrolly.min.js"></script>
			<script src="{$conf->javascripts}jquery.dropotron.min.js"></script>
			<script src="{$conf->javascripts}jquery.scrollex.min.js"></script>
			<script src="{$conf->javascripts}browser.min.js"></script>
			<script src="{$conf->javascripts}breakpoints.min.js"></script>
			<script src="{$conf->javascripts}util.js"></script>
			<script src="{$conf->javascripts}main.js"></script>
			<script src="{$conf->javascripts}functions.js"></script>
	</body>
</html>
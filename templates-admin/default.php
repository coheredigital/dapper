<?php

/**
 * ProcessWire 2.x Admin Markup Template
 *
 * Copyright 2012 by Ryan Cramer
 *
 *
 */

$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';

$config->styles->prepend($config->urls->adminTemplates . "styles/style.css");
$config->styles->prepend($config->urls->adminTemplates . "styles/jqui/jqui.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/inputfields.js");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js?v=2");

$browserTitle = wire('processBrowserTitle');
if(!$browserTitle) $browserTitle = __(strip_tags($page->get('title|name')), __FILE__) . ' &bull; ProcessWire';

/*
 * Dynamic phrases that we want to be automatically translated
 *
 * These are in a comment so that they register with the parser, in place of the dynamic __() function calls with page titles.
 *
 * __("Pages");
 * __("Setup");
 * __("Modules");
 * __("Access");
 * __("Admin");
 *
 */

?>
<!DOCTYPE html>
<html lang="<?php echo __('en', __FILE__); // HTML tag lang attribute
	/* this intentionally on a separate line */ ?>">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $browserTitle; ?></title>

	<script type="text/javascript">
		<?php

		$jsConfig = $config->js();
		$jsConfig['debug'] = $config->debug;
		$jsConfig['urls'] = array(
			'root' => $config->urls->root,
			'admin' => $config->urls->admin,
			'modules' => $config->urls->modules,
			'core' => $config->urls->core,
			'files' => $config->urls->files,
			'templates' => $config->urls->templates,
			'adminTemplates' => $config->urls->adminTemplates,
			);
		?>
		var config = <?php echo json_encode($jsConfig); ?>;
	</script>
	<?php foreach($config->styles->unique() as $file) echo "\n\t<link type='text/css' href='$file' rel='stylesheet' />"; ?>
	<?php foreach($config->scripts->unique() as $file) echo "\n\t<script type='text/javascript' src='$file'></script>"; ?>
</head>
<body class="<?php if($bodyClass) echo $bodyClass;?>">
	<div class='page-header'>
		<div class="container">
			<?php if(!$user->isGuest()): ?>
			<ul class='user-menu'>
				<li>
				<?php if ($user->hasPermission('profile-edit')): ?>
					<a class='action' href='<?php echo $config->urls->admin; ?>profile/'>
				<?php endif ?>
					<?php echo $user->name ?>
				<?php if ($user->hasPermission('profile-edit')): ?>
					</a>
				<?php endif ?>
				</li>
				<li><a class='action' href='<?php echo $config->urls->admin; ?>login/logout/'><?php echo __('logout', __FILE__); ?></a></li>
				<li><a id='sitelink' href='<?php echo $config->urls->root; ?>'><?php echo __('View Site', __FILE__); ?></a></li>
			</ul>
			<?php endif; ?>


			<h1 id='title'>
				<?php echo __(strip_tags($this->fuel->processHeadline ? $this->fuel->processHeadline : $page->get("title|name")), __FILE__); ?>
			</h1>



			<?php if(!$user->isGuest()): ?>

			<ul id='breadcrumb' class='nav-menu nav-bread'><?php
				foreach($this->fuel('breadcrumbs') as $breadcrumb) {
					$title = __($breadcrumb->title, __FILE__);
					echo "\n\t\t\t\t<li><a href='{$breadcrumb->url}'>{$title} <span>&rsaquo;</span></a> </li>";
				}
				?>

			</ul>

			<?php endif; ?>



		</div>
		<div class="nav-wrapper">
			<div class="nav-bar">
				<div class="container">
					<ul class='nav-menu nav-main'>
						<?php include($config->paths->adminTemplates . "topnav.inc"); ?>
						<li class='search-box'><?php echo tabIndent($searchForm, 3); ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>





	<div class="content fouc_fix">
		<div class="container">

			<?php if(count($notices)) include($config->paths->adminTemplates . "notices.inc"); ?>


			<?php if(trim($page->summary)) echo "<h2>{$page->summary}</h2>"; ?>

			<?php if($page->body) echo $page->body; ?>

			<?php echo $content?>

		</div>
	</div>


	<div class="footer">
		<div class="container">
			ProcessWire <?php echo $config->version . ' <!--v' . $config->systemVersion; ?>--> &copy; <?php echo date("Y"); ?> Ryan Cramer
		</div>
		<?php if($config->debug && $this->user->isSuperuser()) include($config->paths->adminTemplates . "debug.inc"); ?>
	</div>




</body>
</html>

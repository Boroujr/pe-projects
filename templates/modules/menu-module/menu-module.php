<?php
$menu = $section['menu'] ?? $menu ?? 'test';
$class = $menu == 'site' || $menu == 'theme' ? "magnetic $menu" : $menu;



if (file_exists("data/components/$menu-menu.json")) {


	if (!$currentTheme) {
		$menuJson = file_get_contents("data/components/theme-menu.json");
	} else {
		$menuJson = file_get_contents("data/components/$menu-menu.json");
	}
	$menuData = json_decode($menuJson, true);
} else {
	$menuData = $section['links'];
}
?>

<nav class="<?= $class ?>-menu">
	<ul>

		<?php foreach ($menuData as $menuItem) {

			$class = $menuItem['class'] ?? "text";
			$slug = $menuItem['slug'];
			$name = $menuItem['name'];
			$target = $menuItem['target'] ?? NULL;



			if ($menu == 'site') {

				if (!$currentTheme) {
					$class = "$class " . activeTheme($menuItem['activePage']);
					// $slug = currentPage() . "?theme=" . $menuItem['slug']; //pretty
					$slug = "?theme=" . $menuItem['slug'] . "&page=" . currentPage(); //ugly
				} else {
					$class = "$class " . activePage($menuItem['activePage'] ?? false);
					// $slug = $menuItem['slug']; //pretty
					$slug = "?page=" . $menuItem['slug']; //ugly
				}
			}
			if ($menu == 'theme') {
				$class = "$class " . activeTheme($menuItem['activePage']);
				// $slug = currentPage() . "?theme=" . $menuItem['slug']; //pretty
				$slug = "?theme=" . $menuItem['slug'] . "&page=" . currentPage(); //ugly

			}
			if ($menu == 'garden') {
				$class = "$class " . activePage($menuItem['activePage'] ?? false);
				// $slug = $menuItem['slug']; //pretty
				$slug =  $menuItem['slug']; //ugly

			}
		?>
			<li>
				<a class="<?= $class ?> " href="<?= $slug ?>" target="<?= $target ?>" data-swup-animation="circle">
					<span><?= $name ?></span>


					<?php if ($target != NULL) { ?>
						<picture class="external-link">
							<img src="images/diagonal-arrow.svg" alt="">
						</picture>
					<?php } ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</nav>
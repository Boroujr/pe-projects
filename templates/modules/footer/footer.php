<footer>
	<svg class="circle magnetic" viewBox="0 0 100 100">
		<circle cx="50" cy="50" r="40" />
	</svg>
	<inner-column class="menus">
		<?php
		$menu = "site";
		include('templates/modules/menu-module/menu-module.php');
		$menu = "theme";
		include('templates/modules/menu-module/menu-module.php');
		?>
	</inner-column>
</footer>
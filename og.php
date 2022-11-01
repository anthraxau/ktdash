		<?php
			// Cleanup/formatting
			$pagetitle = $pagetitle == null ? "KTDash.app" : $pagetitle . " | KTDash.app";
			$pagedesc = $pagedesc == null ? "" : $pagedesc;
			$pagedesc = str_replace('\r\n', ' ', str_replace('"', '\'', str_replace('<br/>', ' ', $pagedesc)));
			$pageimg = $pageimg == null ? "" : $pageimg;
		?>
		
		<!-- General Meta Tags -->
		<title><?php echo $pagetitle ?></title>
		<meta name="description" content="<?php echo $pagedesc ?>">
		
		<!-- OpenGraph Tags -->
		<meta property="og:url" content="<?php echo $pageurl ?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?php echo $pagetitle ?>">
		<meta property="og:description" content="<?php echo $pagedesc ?>">
		<meta property="og:image" content="<?php echo $pageimg ?>">

		<!-- Twitter Meta Tags -->
		<meta name="twitter:card" content="summary_large_image">
		<meta property="twitter:domain" content="ktdash.app">
		<meta property="twitter:url" content="<?php echo $pageurl ?>">
		<meta name="twitter:title" content="<?php echo $pagetitle ?>">
		<meta name="twitter:description" content="<?php echo $pagedesc ?>">
		<meta name="twitter:image" content="<?php echo $pageimg ?>">
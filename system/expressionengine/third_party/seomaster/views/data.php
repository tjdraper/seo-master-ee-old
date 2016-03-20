<title><?= $title ?><?php if ($use_title_suffix) { ?><?= $seo_title_suffix ?><?php } ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?= $description ?>">
<?php } ?>
<?php if ($no_index) { ?>
<meta name="robots" content="noindex,follow">
<?php } ?>
<meta name="twitter:card" content="<?php if ($twitter_card) { ?><?= $twitter_card ?><?php } elseif ($image) { ?>summary_large_image<?php } else { ?>summary<?php } ?>">
<?php if ($twitter_site) { ?>
<meta name="twitter:site" content="@<?= $twitter_site ?>">
<?php } ?>
<meta name="twitter:title" content="<?= $title ?>">
<?php if ($description) { ?>
<meta name="twitter:description" content="<?= $description ?>">
<?php } ?>
<?php if ($image) { ?>
<meta name="twitter:image" content="<?= $image ?>">
<?php } ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?= $title ?>" itemprop="name">
<?php if ($description) { ?>
<meta property="og:description" content="<?= $description ?>" itemprop="description">
<?php } ?>
<?php if ($image) { ?>
<meta property="og:image" content="<?= $image ?>" itemprop="image">
<?php } ?>

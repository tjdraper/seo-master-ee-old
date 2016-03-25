<div class="seomaster-field" data-set="pageType" data-value="fieldType">

	<?php // No Index ?>
	<?php if ($fieldSettings->display_indexing) { ?>
		<div class="seomaster-field__input-wrapper">
			<label class="seomaster-field__label">
				<?= lang('field_seo_no_index') ?>
			</label>
			<div class="seomaster-field__inputs">
				<label class="choice mr<?php if ($fieldData->no_index === null || $fieldData->no_index === false) { ?> chosen<?php } ?>">
					<input
						type="radio"
						name="<?= $fieldSettings->field_name ?>[no_index]"
						value="n"
						<?php if ($fieldData->no_index === null || $fieldData->no_index === false) { ?>
						checked
						<?php } ?>
					>
					<?= lang('field_seo_no_index_index') ?>
				</label>
				<label class="choice mr<?php if ($fieldData->no_index === true) { ?> chosen<?php } ?>">
					<input
						type="radio"
						name="<?= $fieldSettings->field_name ?>[no_index]"
						value="y"
						<?php if ($fieldData->no_index === true) { ?>
						checked
						<?php } ?>
					>
					<?= lang('field_seo_no_index_no_index') ?>
				</label>
			</div>
		</div>
	<?php } ?>

	<?php // Use SEO Title Suffix ?>
	<?php if ($fieldSettings->display_title_suffix) { ?>
		<div class="seomaster-field__input-wrapper">
			<label class="seomaster-field__label">
				<?= lang('field_seo_title_suffix') ?>
			</label>
			<div class="seomaster-field__inputs">
				<label class="choice mr<?php if ($fieldData->use_title_suffix === null || $fieldData->use_title_suffix === true) { ?> chosen<?php } ?>">
					<input
						type="radio"
						name="<?= $fieldSettings->field_name ?>[use_title_suffix]"
						value="y"
						<?php if ($fieldData->use_title_suffix === null || $fieldData->use_title_suffix === true) { ?>
						checked
						<?php } ?>
					>
					<?= lang('yes') ?>
				</label>
				<label class="choice mr<?php if ($fieldData->use_title_suffix === false) { ?> chosen<?php } ?>">
					<input
						type="radio"
						name="<?= $fieldSettings->field_name ?>[use_title_suffix]"
						value="n"
						<?php if ($fieldData->use_title_suffix === false) { ?>
						checked
						<?php } ?>
					>
					<?= lang('no') ?>
				</label>
			</div>
		</div>
	<?php } ?>

	<?php // SEO Title ?>
	<?php if ($fieldSettings->display_title) { ?>
		<div
			class="seomaster-field__input-wrapper<?php if ($fieldSettings->title_max_length) { ?> js-seomaster-limited<?php } ?>"
			<?php if ($fieldSettings->title_max_length) { ?>
			data-limit="<?= $fieldSettings->title_max_length ?>"
			<?php } ?>
		>
			<label for="$fieldSettings->field_name ?>[title]" class="seomaster-field__label">
				<?= lang('field_seo_title_label') ?>
				<div class="instruction_text seomaster-field__input-explain">
					<?= lang('field_seo_title_explain') ?>
				</div>
			</label>
			<input
				type="text"
				name="<?= $fieldSettings->field_name ?>[title]"
				value="<?= $fieldData->title ?>"
				placeholder="<?= lang('field_seo_title_placeholder') ?>"
				<?php if ($fieldSettings->title_max_length) { ?>
				maxlength="<?= $fieldSettings->title_max_length ?>"
				<?php } ?>
				class="seomaster-field__input js-seomaster-input"
				id="$fieldSettings->field_name ?>[title]"
			>
			<?php if ($fieldSettings->title_max_length) { ?>
				<?= ee()->load->view('embed/counter', array(
					'value' => $fieldData->title,
					'maxLength' => $fieldSettings->title_max_length
				)) ?>
			<?php } ?>
		</div>
	<?php } ?>

	<?php // SEO Description ?>
	<?php if ($fieldSettings->display_description) { ?>
		<div
			class="seomaster-field__input-wrapper<?php if ($fieldSettings->description_max_length) { ?> js-seomaster-limited<?php } ?>"
			<?php if ($fieldSettings->description_max_length) { ?>
			data-limit="<?= $fieldSettings->description_max_length ?>"
			<?php } ?>
		>
			<label for="$fieldSettings->field_name ?>[description]" class="seomaster-field__label">
				<?= lang('field_seo_description_label') ?>
			</label>
			<textarea
				name="<?= $fieldSettings->field_name ?>[description]"
				placeholder="<?= lang('field_seo_description_placeholder') ?>"
				<?php if ($fieldSettings->description_max_length) { ?>
				maxlength="<?= $fieldSettings->description_max_length ?>"
				<?php } ?>
				rows="3"
				class="seomaster-field__input js-seomaster-input"
				id="$fieldSettings->field_name ?>[description]"
			><?= $fieldData->description ?></textarea>
			<?php if ($fieldSettings->description_max_length) { ?>
				<?= ee()->load->view('embed/counter', array(
					'value' => $fieldData->title,
					'maxLength' => $fieldSettings->description_max_length
				)) ?>
			<?php } ?>
		</div>
	<?php } ?>

	<?php // Share Image ?>
	<?php if ($fieldSettings->display_share_image) { ?>
		<div class="seomaster-field__input-wrapper">
			<label class="seomaster-field__label">
				<?= lang('field_add_share_image_label') ?>
			</label>
			<input type="hidden" name="<?= $fieldSettings->field_name ?>[image]" value="<?php if ($fieldData->image->file_id) { ?><?= $fieldData->image->file_id ?><?php } ?>" class="js-seomaster-image">
			<div class="seomaster-field__share-image-thumb<?php if (! $fieldData->image->file_id) { ?> js-hide<?php } ?> js-seomaster-thumb-wrapper">
				<span class="seomaster-close-btn seomaster-field__thumb-delete js-thumb-delete"></span>
				<div class="js-seomaster-image-thumb">
					<?php if ($fieldData->image->file_id) { ?>
						<img src="<?= $fieldData->image->upload_location_url ?>_thumbs/<?= $fieldData->image->file_name ?>">
					<?php } ?>
				</div>
			</div>
			<div class="seomaster-field__share-img-btn-wrapper">
				<?= $shareBtn ?>
			</div>
		</div>
	<?php } ?>

</div>

<div class="seomaster-field" data-set="pageType" data-value="fieldType">

	<input
		type="hidden"
		name="<?= $fieldSettings->field_name ?>[entry_id]"
		value="<?= $fieldData->entry_id ?>"
	>

	<?php // No Index ?>
	<?php if ($fieldSettings->display_indexing) { ?>
		<div class="seomaster-field__input-wrapper">
			<label class="seomaster-field__label">
				<?= lang('field_seo_no_index') ?>
			</label>
			<input
				type="radio"
				name="$fieldSettings->field_name ?>[no_index]"
				value="n"
				id="no_index_no"
				<?php if ($fieldData->no_index === null || $fieldData->no_index === true) { ?>
				checked
				<?php } ?>
			>
			<label for="no_index_no" class="seomaster-radio-label"><?= lang('field_seo_no_index_index') ?></label>
			<input
				type="radio"
				name="$fieldSettings->field_name ?>[no_index]"
				value="y"
				id="no_index_yes"
				<?php if ($fieldData->no_index === false) { ?>
				checked
				<?php } ?>
			>
			<label for="no_index_yes" class="seomaster-radio-label"><?= lang('field_seo_no_index_no_index') ?></label>
		</div>
	<?php } ?>

	<?php // Use SEO Title Suffix ?>
	<?php if ($fieldSettings->display_title_suffix) { ?>
		<div class="seomaster-field__input-wrapper">
			<label class="seomaster-field__label">
				<?= lang('field_seo_title_suffix') ?>
			</label>
			<input
				type="radio"
				name="$fieldSettings->field_name ?>[use_title_suffix]"
				value="y"
				id="use_title_suffix_yes"
				<?php if ($fieldData->use_title_suffix === null || $fieldData->use_title_suffix === true) { ?>
				checked
				<?php } ?>
			>
			<label for="use_title_suffix_yes" class="seomaster-radio-label"><?= lang('yes') ?></label>
			<input
				type="radio"
				name="$fieldSettings->field_name ?>[use_title_suffix]"
				value="n"
				id="use_title_suffix_no"
				<?php if ($fieldData->use_title_suffix === false) { ?>
				checked
				<?php } ?>
			>
			<label for="use_title_suffix_no" class="seomaster-radio-label"><?= lang('no') ?></label>
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
				class="js-seomaster-input"
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
				class="js-seomaster-input"
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
			<input type="hidden" name="<?= $fieldSettings->field_name ?>[image]" value="<?= $fieldData->image ?>" class="js-seomaster-image">
			<div class="seomaster-field__share-image-thumb"></div>
			<span
				class="seomaster-btn js-seomaster-add-image"
				data-add="<?= lang('field_add_share_image') ?>"
				data-remove="<?= lang('field_remove_share_image') ?>"
				data-has-image="<?= $fieldData->image ? 'true' : 'false' ?>"
			>
				<?= lang('field_add_share_image') ?>
			</span>
		</div>
	<?php } ?>

</div>

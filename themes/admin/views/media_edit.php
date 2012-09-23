<?php

/**
 * Modal window for Media metadata edition
 *
 */

$pictureSize = NULL;

if($type == 'picture')
{
	$pictureSize = @getimagesize(DOCPATH.$path);
}

?>

<!-- Media summary -->
<div class="summary">

	<!-- Picture file -->
	<?php if($type == 'picture') :?>
		<?php
			$thumb_size = (Settings::get('media_thumb_size') != '') ? Settings::get('media_thumb_size') : '120';
		 ?>
		<div class="picture" style="float:right;margin:0;">
		<div class="thumb" style="width:<?= $thumb_size ?>px;height:<?= $thumb_size ?>px;background-image:url(<?= admin_url(TRUE) . 'media/get_thumb/'.$id_media.'/'.time()  ?>);"></div>
		</div>
	<?php endif ;?>

	<!-- Music file -->
	<?php if($type == 'music') :?>
		<div style="float:right;">
			<embed
                src="<?= theme_url() ?>flash/mp3Player/mp3player_simple.swf?mp3=<?= base_url().$path ?>"
                loop="false"
                menu="false"
                quality="high"
                wmode="transparent"
                width="224"
                height="20"
                name="track_<?= $id_media ?>"
                align="middle"
                allowScriptAccess="sameDomain"
                type="application/x-shockwave-flash"
                pluginspage="http://www.macromedia.com/go/getflashplayer"
            />
		</div>
	<?php endif ;?>
	
	<!-- Video file -->
	<?php if($type == 'video') :?>
		
		<?php if($is_external == TRUE) :?>

			<iframe  style="float:right;" width="170" height="145" src="<?= $path?>" frameborder="0" allowfullscreen></iframe>
		
			<h3><?= lang('ionize_title_informations') ?></h3>

		
		<?php else :?>

			<div style="float:right;"  id="video<?= $id_media ?>">
                <embed
                    flashvars="file=<?=base_url().$path?>&autostart=false"
                    allowfullscreen="true"
                    allowscriptaccess="always"
                    id="video<?= $id_media ?>"
                    name="video<?= $id_media ?>"
                    src="<?= theme_url() ?>flash/mediaplayer/player.swf"
                    width="170"
                    height="145"
                />
            </div>

			<h3><?= lang('ionize_title_informations') ?></h3>
		
		<?php endif ;?>
	<?php endif ;?>
	

	<!-- Picture file -->
	<?php if($type == 'picture') :?>

		<h3><?= lang('ionize_title_informations') ?></h3>
		
		<!-- Thumbs status -->
		<dl class="small">
			<?php foreach($thumbs as $thumb) :?>

				<?php
				
					$size = explode(',', $thumb['content']);
					$size = $size[1];
				
				?>

				<dt>
					<label><?=substr($thumb['name'], strpos($thumb['name'], '_') + 1) ?> : <?= $size ?></label>
				</dt>
				<dd>
					<?php if (file_exists(DOCPATH.$base_path.$thumb['name'].'/'.$file_name)) :?>
						<img src="<?= theme_url() ?>images/icon_16_ok.png" />
					<?php else: ?>
						<img src="<?= theme_url() ?>images/icon_16_delete.png" />
					<?php endif; ?>
				</dd>
	
			<?php endforeach ;?>
		</dl>

	<?php endif ;?>

	<!-- File size in ko -->
	<dl class="small">

		<?php if($is_external == FALSE) :?>

			<dt>
				<label><?= lang('ionize_label_file_size') ?></label>
			</dt>
			<dd>
				<?php if (file_exists(DOCPATH . $path)) :?>
					<?php echo sprintf('%01.2f', filesize(DOCPATH . $path) / (1024 )) ?> ko
				<?php else :?>
					<?php echo(lang('ionize_exception_no_source_file')) ;?>
				<?php endif ;?>
			
				<?php if($type == 'picture') :?>
					 - 
					<?php if ( ! is_null($pictureSize)) :?>
						<?php echo($pictureSize['0']) ?> x <?php echo($pictureSize['1']) ?> px
						<br /><a id="imageCropLink<?= $id_media ?>">crop image</a>
					<?php endif ;?> 
				<?php endif ;?>
			</dd>		
		
		<?php endif ;?>
	</dl>
	<dl class="small">
		<dt>
			<label><?= lang('ionize_label_file_path') ?></label>
		</dt>
		<dd>
			<?php echo auto_link($path, 'both', true) ;?>

		</dd>
	
	</dl>

	
</div>


<?php if ($id_media != '') :?>
	<!-- Modules PlaceHolder -->
	<?= get_modules_addons('media', 'main_top'); ?>
<?php endif ;?>


<!-- Media form -->
<form name="mediaForm<?= $id_media ?>" id="mediaForm<?= $id_media ?>" action="<?= admin_url() ?>media/save">

	<input type="hidden" name="id_media" value="<?= $id_media ?>" />
	<input type="hidden" name="type" value="<?= $type ?>" />

	<!-- Context data -->
	<input type="hidden" name="parent" value="<?= $parent ?>" />
	<input type="hidden" name="id_parent" value="<?= $id_parent ?>" />

	<!-- Lang data -->
	<fieldset id="picture-lang">
		
		<!-- Tabs -->
		<div id="mediaTab<?= $UNIQ ?>" class="mainTabs">
			<ul class="tab-menu">
				<?php foreach(Settings::get_languages() as $l) :?>
					<li<?php if($l['def'] == '1') :?> class="dl"<?php endif ;?>><a><span><?= ucfirst($l['name']) ?></span></a></li>
				<?php endforeach ;?>
				<?php if($type == 'picture') :?>
					<li class="right"><a><span><?= lang('ionize_title_options'); ?></span></a></li>
				<?php endif ;?>
				<li class="right"><a><span><?= lang('ionize_title_details'); ?></span></a></li>
			</ul>
			<div class="clear"></div>
		</div>


		<div id="mediaTabContent<?= $UNIQ ?>">	


			<!-- Translated Meta data -->
			<?php foreach(Settings::get_languages() as $language) :?>

			<?php $lang_code = $language['lang']; ?>
			
			<div class="tabcontent<?= $UNIQ ?>">

				<!-- title -->
				<dl class="small">
					<dt>
						<label for="title_<?= $lang_code ?><?= $type.$id_media ?>"><?= lang('ionize_label_title') ?></label>
					</dt>
					<dd>
						<input id="title_<?= $lang_code ?><?= $type.$id_media ?>" name="title_<?= $lang_code ?>" class="inputtext" type="text" value="<?= ${$lang_code}['title'] ?>"/>
						<a class="icon clearfield" data-id="title_<?= $lang_code ?><?= $type.$id_media ?>"></a>
					</dd>
				</dl>
		
				<?php if(pathinfo(FCPATH.$path, PATHINFO_EXTENSION) == 'mp3') :?>
				
				<dl class="small mt10">
					<dt>
						<label</label>
					</dt>
					<dd class="lite"><?= lang('ionize_message_alt_desc_for_mp3') ?></dd>
				</dl>
				<?php endif ;?>
		
				<!-- alternative text -->
				<dl class="small">
					<dt>
						<label for="alt_<?= $lang_code ?><?= $type.$id_media ?>"><?= lang('ionize_label_alt') ?></label>
					</dt>
					<dd>
						<input id="alt_<?= $lang_code ?><?= $type.$id_media ?>" name="alt_<?= $lang_code ?>" class="inputtext" type="text" value="<?= ${$lang_code}['alt'] ?>"/>
						<a class="icon clearfield" data-id="alt_<?= $lang_code ?><?= $type.$id_media ?>"></a>
					</dd>
				</dl>
		
				<!-- description -->
				<dl class="small">
					<dt>
						<label for="description_<?= $lang_code ?><?= $type.$id_media ?>"><?= lang('ionize_label_description') ?></label>
					</dt>
					<dd>
						<input id="description_<?= $lang_code ?><?= $type.$id_media ?>" name="description_<?= $lang_code ?>" class="inputtext" type="text" value="<?= ${$lang_code}['description'] ?>"/>
						<a class="icon clearfield" data-id="description_<?= $lang_code ?><?= $type.$id_media ?>"></a>
					</dd>
				</dl>

				<!-- extend fields goes here... -->
				<?php foreach($extend_fields as $extend_field) :?>
					<?php if ($extend_field['translated'] == '1') :?>
					
						<dl class="small">
							<dt>
								<?php
									$label = ( ! empty($extend_field['langs'][Settings::get_lang('default')]['label'])) ? $extend_field['langs'][Settings::get_lang('default')]['label'] : $extend_field['name'];
								?>
								<label for="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang_code ?>" title="<?= $extend_field['description'] ?>"><?= $label ?></label>
							</dt>
							<dd>
								<?php if ($extend_field['type'] == '1') :?>
									<input id="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang_code ?>" class="inputtext w340" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang_code ?>" value="<?= $extend_field[$lang_code]['content'] ?>" />
								<?php endif ;?>
								<?php if ($extend_field['type'] == '2' || $extend_field['type'] == '3') :?>
									<textarea id="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang_code ?>" class="inputtext w340 h80" name="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang_code ?>"><?= $extend_field[$lang_code]['content'] ?></textarea>
								<?php endif ;?>
							</dd>
						</dl>	
							
					<?php endif ;?>
				<?php endforeach ;?>

			</div>
			<?php endforeach ;?>

			<!-- Thumbnails preferences -->
			<?php if($type == 'picture') :?>
				<div class="tabcontent<?= $UNIQ ?>">
					
					<!-- Thumbnail square crop area -->
					<dl class="small">
						<dt><?= lang('ionize_label_square_crop_area') ?>&nbsp;&nbsp;</dt>
						<dd>
							<input id="square_crop_<?= $id_media ?>_1" name="square_crop" type="radio" value="tl"<?php if ($square_crop == 'tl'): ?> checked="checked"<?php endif; ?>><label for="square_crop_<?= $id_media ?>_1"><?= lang('ionize_label_top_left') ?></label></input><br />
							<input id="square_crop_<?= $id_media ?>_2" name="square_crop" type="radio" value="m"<?php if ($square_crop == 'm'): ?> checked="checked"<?php endif; ?>><label for="square_crop_<?= $id_media ?>_2"><?= lang('ionize_label_middle') ?></label></input><br />
							<input id="square_crop_<?= $id_media ?>_3" name="square_crop" type="radio" value="br"<?php if ($square_crop == 'br'): ?> checked="checked"<?php endif; ?>><label for="square_crop_<?= $id_media ?>_3"><?= lang('ionize_label_bottom_right') ?></label></input>
						</dd>
					</dl>

				</div>
			<?php endif ;?>
			
			<div class="tabcontent<?= $UNIQ ?>">

				<!-- Lang display -->
				<dl class="small">
					<dt><label for="lang_<?= $type.$id_media ?>"><?=lang('ionize_label_media_limit_display_to_lang')?></label></dt>
					<dd>
						<input type="radio" name="lang_display" id="display_all" value="" <?php if($context_data['lang_display'] == ''):?>checked="checked"<?php endif ;?>/><label for="display_all"><?=lang('ionize_label_media_no_limit_display')?></label>
						<?php foreach(Settings::get_languages() as $language) :?>
						<input id="display_<?= $language['lang']; ?>" type="radio" name="lang_display" value="<?= $language['lang']; ?>"  <?php if($context_data['lang_display'] == $language['lang']):?>checked="checked"<?php endif ;?>/><label for="display_<?= $language['lang']; ?>"><img alt="<?= $language['lang']; ?>" src="<?= theme_url() ?>/images/world_flags/flag_<?= $language['lang']; ?>.gif" /></label>
						<?php endforeach; ?>
					</dd>
				</dl>
			
				<!-- Container -->
				<dl class="small">
					<dt><label for="container_<?= $type.$id_media ?>"><?=lang('ionize_label_media_container')?></label></dt>
					<dd>
						<input id="container_<?= $type.$id_media ?>" name="container" class="inputtext" type="text" value="<?= $container ?>" />
						<a class="icon clearfield" data-id="container_<?= $type.$id_media ?>"></a>
					</dd>
				</dl>
			
				<!-- Copyright -->
				<dl class="small">
					<dt><label for="copyright"><?=lang('ionize_label_copyright')?></label></dt>
					<dd>
						<input id="copyright_<?= $type.$id_media ?>" name="copyright" class="inputtext" type="text" value="<?= $copyright ?>" />
						<a class="icon clearfield" data-id="copyright_<?= $type.$id_media ?>"></a>
					</dd>
				</dl>
			
				<!-- Link (URL) -->
				<dl class="small">
					<dt><label for="link"><?=lang('ionize_label_link')?></label></dt>
					<dd>
						<input id="link_<?= $type.$id_media ?>" name="link" type="text" class="inputtext" value="<?= $link ?>" />
						<a class="icon clearfield" data-id="link_<?= $type.$id_media ?>"></a>
					</dd>
				</dl>
			
				<!-- Date -->
				<dl class="small">
					<dt><label for="date_<?= $type.$id_media ?>"><?=lang('ionize_label_date')?></label></dt>
					<dd>
						<input id="date_<?= $type.$id_media ?>" name="date" type="text" class="inputtext date" value="<?= humanize_mdate($date, Settings::get('date_format'). ' %H:%i:%s') ?>" />
						<a class="icon clearfield date" data-id="date_<?= $type.$id_media ?>"></a>
					</dd>
				</dl>

				<!-- extend fields goes here... -->
				<?php foreach($extend_fields as $extend_field) :?>
				
					<?php if ($extend_field['translated'] != '1') :?>
					
						<dl class="small">
							<dt>
								<?php
									$label = ( ! empty($extend_field['langs'][Settings::get_lang('default')]['label'])) ? $extend_field['langs'][Settings::get_lang('default')]['label'] : $extend_field['name'];
								?>
								<label for="cf_<?= $extend_field['id_extend_field'] ?>" title="<?= $extend_field['description'] ?>"><?= $label ?></label>
							</dt>
							<dd>
								<?php
									$extend_field['content'] = ($extend_field['content'] != '') ? $extend_field['content'] : $extend_field['default_value'];
								?>
							
								<?php if ($extend_field['type'] == '1') :?>
									<input id="cf_<?= $extend_field['id_extend_field'] ?>" class="inputtext w200" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $extend_field['content']  ?>" />
								<?php endif ;?>
								
								<?php if ($extend_field['type'] == '2' OR $extend_field['type'] == '3') :?>
									<textarea id="cf_<?= $extend_field['id_extend_field'] ?>" class="<?php if($extend_field['type'] == '3'):?> tinyTextarea <?php endif ;?> inputtext w340 h80" name="cf_<?= $extend_field['id_extend_field'] ?>"><?= $extend_field['content'] ?></textarea>
								<?php endif ;?>
								
								<!-- Checkbox -->
								<?php if ($extend_field['type'] == '4') :?>
									
									<?php
										$pos = 		explode("\n", $extend_field['value']);
										$saved = 	explode(',', $extend_field['content']);
									?>
									<?php
										$i = 0; 
										foreach($pos as $values)
										{
											$vl = explode(':', $values);
											$key = $vl[0];
											$value = (!empty($vl[1])) ? $vl[1] : $vl[0];
			
											?>
											<input type="checkbox" id= "cf_<?= $extend_field['id_extend_field'].$i ?>" name="cf_<?= $extend_field['id_extend_field'] ?>[]" value="<?= $key ?>" <?php if (in_array($key, $saved)) :?>checked="checked" <?php endif ;?>><label for="cf_<?= $extend_field['id_extend_field'] . $i ?>"><?= $value ?></label></input><br/>
											<?php
											$i++;
										}
									?>
								<?php endif ;?>
								
								<!-- Radio -->
								<?php if ($extend_field['type'] == '5') :?>
									
									<?php
										$pos = explode("\n", $extend_field['value']);
									?>
									<?php
										$i = 0; 
										foreach($pos as $values)
										{
											$vl = explode(':', $values);
											$key = $vl[0];
											$value = (!empty($vl[1])) ? $vl[1] : $vl[0];
			
											?>
											<input type="radio" id= "cf_<?= $extend_field['id_extend_field'].$i ?>" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $key ?>" <?php if ($extend_field['content'] == $key) :?> checked="checked" <?php endif ;?>><label for="cf_<?= $extend_field['id_extend_field'] . $i ?>"><?= $value ?></label></input><br/>
											<?php
											$i++;
										}
									?>
								<?php endif ;?>
								
								<!-- Selectbox -->
								<?php if ($extend_field['type'] == '6' && !empty($extend_field['value'])) :?>
									
									<?php									
										$pos = explode("\n", $extend_field['value']);
										$saved = 	explode(',', $extend_field['content']);
									?>
									<select name="cf_<?= $extend_field['id_extend_field']?>">
									<?php
										$i = 0; 
										foreach($pos as $values)
										{
											$vl = explode(':', $values);
											$key = $vl[0];
											$value = (!empty($vl[1])) ? $vl[1] : $vl[0];
											?>
											<option value="<?= $key ?>" <?php if (in_array($key, $saved)) :?> selected="selected" <?php endif ;?>><?= $value ?></option>
											<?php
											$i++;
										}
									?>
									</select>
								<?php endif ;?>
								
								
								<!-- Date & Time -->
								<?php if ($extend_field['type'] == '7') :?>
								
									<input id="cf_<?= $extend_field['id_extend_field'] ?>" class="inputtext w120 date" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $extend_field['content']  ?>" />
									
								<?php endif ;?>
								
							</dd>
						</dl>	
							
					<?php endif ;?>
				<?php endforeach ;?>
		
			</div>
		
		</div>
		
	</fieldset>


</form>

<div class="buttons">
	<button id="bSave<?= $type.$id_media ?>" type="button" class="button yes right mr40"><?= lang('ionize_button_save_close') ?></button>
	<button id="bCancel<?= $type.$id_media ?>"  type="button" class="button no right"><?= lang('ionize_button_cancel') ?></button>
</div>


<script type="text/javascript">

	/**
	 * Calendars init
	 *
	 */
	ION.initDatepicker();

	/**
	 * Clear Field Init
	 */
	ION.initClearField('#mediaForm<?= $id_media ?>');

	/** 
	 * Tabs init
	 *
	 */
	new TabSwapper({tabsContainer: 'mediaTab<?= $UNIQ ?>', sectionsContainer: 'mediaTabContent<?= $UNIQ ?>', selectedClass: 'selected', deselectedClass: '', tabs: 'li', clickers: 'li a', sections: 'div.tabcontent<?= $UNIQ ?>' });

	
	/**
	 * Opens the crop window if picture
	 *
	 */
	
	<?php if ( ! is_null($pictureSize)) :?>
	if (typeOf($('imageCropLink<?= $id_media ?>')) != 'null')
	{
		$('imageCropLink<?= $id_media ?>').addEvent('click', function()
		{
			// Should be : 'maximizable': true, 
			ION.dataWindow('ImageCrop<?= $id_media ?>', Lang.get('ionize_label_media_crop_picture'), 'media/get_crop/<?= $id_media ?>', {width:660, height:480, padding:0});
		});
	}
	<?php endif ;?>

</script>

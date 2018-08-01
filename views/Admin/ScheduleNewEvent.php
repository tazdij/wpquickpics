<div class="wrap">
	<h2 style="border-bottom: 1px solid #ccc;">
		<span style=""><?php _e('Schedule New Event', 'tzdj_olympic'); ?></span> <span style="font-size: 0.6em">Olympic Personal Trainer</span>
	</h2>
	<div style="text-align: right;">A <span style="font-family: 'Arvo', serif; font-weight: bold;">Tazd'ij</span><span style="font-family: 'Arvo', serif;">Services</span> product</div>
	
	<form name="newbulletin" method="post" action="">
 
		<table class="form-table">
			<tbody>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Event Name', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventName" name="EventName" type="text" value="<?=$_POST['EventName']?>" />
						<label class="description" for="EventName"><?php _e('Please supply the Event\'s Title', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Event Date', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventDate" name="EventDate" type="text" value="<?=$_POST['EventDate']?>" />
						<label class="description" for="EventName"><?php _e('Please supply the Event\'s Date', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Event Time', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventTime" name="EventTime" type="text" value="<?=$_POST['EventTime']?>" />
						<label class="description" for="EventTime"><?php _e('Please supply the Event\'s Time', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Use Event End Date', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventHasEndDate" name="EventHasEndDate" type="checkbox" value="1"  <?php checked(1, $_POST['EventHasEndDate']); ?> />
						<label class="description" for="EventHasEndDate"><?php _e('Does this event have an end date?', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				
				
				<tr valign="top" style="display: none;" class="EndDateRec">	
					<th scope="row" valign="top">
						<?php _e('Event End Date', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventEndDate" name="EventEndDate" type="text" value="<?=$_POST['EventEndDate']?>" />
						<label class="description" for="EventEndName"><?php _e('Please supply the Event\'s End Date', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				
				<tr valign="top" style="display: none;" class="EndDateRec">	
					<th scope="row" valign="top">
						<?php _e('Event End Time', 'hvst_bulletins'); ?>
					</th>
					<td>
						<input id="EventEndTime" name="EventEndTime" type="text" value="<?=$_POST['EventEndTime']?>" />
						<label class="description" for="EventEndTime"><?php _e('Please supply the Event\'s End Time', 'hvst_bulletin'); ?></label>
					</td>
				</tr>
				<!--
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Version', 'hvst_scripthigh'); ?>
					</th>
					<td>
						<select name="hvst_scripthigh_settings[version]">
							<option value="" <?=($scripthigh_settings['version'] == "") ? 'selected' : ''?> >-- Default Version --</option>
							<?php foreach ($versions as $code => $name): ?>
								<?php
									$title = mb_substr($name, 0, 25);
									
									if (strlen($title) < strlen($name)) {
										$title = $code . ' - ' . $title . '...';
									} else {
										$title = $code . ' - ' . $name;
									}
								?>
							<option value="<?=$code?>" <?=($scripthigh_settings['version'] == $code) ? 'selected' : ''?> ><?=$title?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				-->
				
			</tbody>
		</table>
		<br />
		<br />
		
		<p class="submit">
			<input type="submit" class="button-primary" name="submit" value="<?php _e('Save Options', 'mfwp_domain'); ?>" />
		</p>
 
	</form>
</div>

<script>
	jQuery(document).ready(function($){
		$('#EventDate').datepicker();
		$('#EventTime').timepicker();
		$('#EventEndDate').datepicker();
		$('#EventEndTime').timepicker();
		
		// Handle the check state of EndDate
		if ($('#EventHasEndDate').is(':checked')) {
			// This is checked
			$('.EndDateRec').show();
			
		}
		
		$('#EventHasEndDate').click(function() {
			if ($(this).is(':checked')) {
				$('.EndDateRec').show();
			} else {
				$('.EndDateRec').hide();
			}
		});
		
		
	});
</script>
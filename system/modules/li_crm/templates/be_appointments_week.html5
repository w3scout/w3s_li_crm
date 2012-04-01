<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<input type="hidden" name="REQUEST_TOKEN" value="<?php echo REQUEST_TOKEN; ?>" />
	<div class="tl_panel">
		<div class="tl_submit_panel tl_subpanel">
			<input type="image" name="filter" id="filter" src="system/themes/default/images/reload.gif"
				class="tl_img_submit" title="<?php echo $GLOBALS['TL_LANG']['MSC']['apply'] ; ?>" alt="<?php echo $GLOBALS['TL_LANG']['MSC']['apply'] ; ?>">
		</div>
		<div class="tl_search tl_subpanel">
			<strong><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['year']; ?>:</strong>
			<input type="text" name="appointments_year" class="tl_text" value="<?php echo $this->year; ?>">	
		</div>
		<div class="tl_search tl_subpanel">
			<strong><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['week']; ?>:</strong>
			<input type="text" name="appointments_week" class="tl_text" value="<?php echo $this->week; ?>">	
		</div>
		<div class="clear"></div>
	</div>
</form>
<div id="tl_buttons">
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['new'][1]; ?>"
		class="add_date" href="contao/main.php?do=li_appointments&table=tl_li_appointment&act=create"
		style="background-image: url('../../system/themes/default/images/new.gif');">
		<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['new'][0]; ?>
    </a>
     &nbsp; :: &nbsp;
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['monthView'][1]; ?>"
		class="manage_work_packages" href="contao/main.php?do=li_appointments"
		style="background-image: url(system/modules/li_crm/icons/appointments_month.png);">
        <?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['monthView'][0]; ?>
    </a>
    &nbsp; :: &nbsp;
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['weekView'][1]; ?>"
		class="manage_work_packages" href="contao/main.php?do=li_appointments&view=week"
		style="background-image: url(system/modules/li_crm/icons/appointments_week.png);">
        <?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['weekView'][0]; ?>
    </a>
    &nbsp; :: &nbsp;
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['dayView'][1]; ?>"
		class="manage_work_packages" href="contao/main.php?do=li_appointments&view=day"
		style="background-image: url(system/modules/li_crm/icons/appointments_day.png);">
        <?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['dayView'][0]; ?>
    </a>
</div>
<div id="month_buttons">
	<a href="contao/main.php?do=li_appointments&view=week&appointments_year=<?php echo $this->prevYear; ?>&appointments_week=<?php echo $this->prevWeek; ?>"
	   title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['prevWeek']; ?>">
		<img src="system/modules/li_crm/icons/arrow_left.png" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['prevWeek']; ?>"/>
	</a>
	<a style="float:right;" href="contao/main.php?do=li_appointments&view=week&appointments_year=<?php echo $this->nextYear; ?>&appointments_week=<?php echo $this->nextWeek; ?>"
	   title="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['nextWeek']; ?>">
		<img src="system/modules/li_crm/icons/arrow_right.png" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['nextWeek']; ?>"/>
	</a>
</div>
<div id="appointments_wrapper">
	<div id="appointments_week">
		<div class="ruler">
			<div class="headline">
				<span><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['time']; ?></span>
			</div>
			<?php for($i = 0; $i < 24; $i = $i + 0.5): ?>
			<div class="hour<?php echo $i == 23.5 ? ' last' : ''; ?>">
				<span><?php echo ($i < 10 ? '0'.floor($i) : floor($i)).':'.($i == floor($i) ? '00' : '30'); ?></span>
			</div>
			<?php endfor; ?>
		</div>
		<?php $dayCounter = 0; ?>
		<?php foreach($this->days as $day): ?>
		<?php $dayCounter++; ?>
		<div class="day<?php echo $dayCounter == 1 ? ' first' : ''; echo $dayCounter == 7 ? ' last' : ''; ?>">
			<div class="headline">
				<span class="date"><?php echo $day['date']; ?></span>
			</div>
			<?php for($i = 0; $i < 48; $i++): ?>
			<div class="hour<?php echo $i == 47 ? ' last' : ''; ?>">
				<?php $appointments = $day['appointments']; ?>
				<?php if($appointments[$i] != null): ?>
				<?php foreach($appointments[$i] as $appointment): ?>
				<div class="appointment" style="background-color:#<?php echo $appointment['color']; ?>;top:<?php echo $appointment['top'].'px'; ?>;left:<?php echo ($appointment['left'] - 1).'px'; ?>;height:<?php echo $appointment['height'].'px'; ?>;width:<?php echo (85 - $appointment['left']).'px'; ?>">
					<a class="details subject" href="system/modules/li_crm/DetailsBox.php?table=tl_li_appointment&id=<?php echo $appointment['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_appointment']['edit'][1], $appointment['id']); ?>" rel="lightbox[610 80%]" style="width:<?php echo (67 - $appointment['left']).'px'; ?>">
						<?php echo $appointment['subject']; ?>
					</a>
					<div class="options">
						<a class="delete" href="contao/main.php?do=li_appointments&table=tl_li_appointment&act=delete&id=<?php echo $appointment['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_appointment']['delete'][1], $appointment['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $appointment['id']); ?>')) return false; Backend.getScrollOffset();" "="">
							<img src="system/modules/li_crm/icons/delete.png" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['delete'][0]; ?>" width="16" height="16">
						</a>
						<a class="edit" href="contao/main.php?do=li_appointments&table=tl_li_appointment&act=edit&id=<?php echo $appointment['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_appointment']['edit'][1], $appointment['id']); ?>">
							<img src="system/modules/li_crm/icons/edit.png" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['edit'][0]; ?>" width="16" height="16">
						</a>
					</div>
					<br class="clear" />
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<?php endfor; ?>
		</div>
		<?php endforeach; ?>
		<br class="clear" />
	</div>
</div>

<?php $lang = $this->lang; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<input type="hidden" name="REQUEST_TOKEN" value="<?php echo REQUEST_TOKEN; ?>" />
	<div class="tl_panel">
		<div class="tl_submit_panel tl_subpanel">
			<input type="image" name="filter" id="filter" src="system/themes/default/images/reload.gif"
				   class="tl_img_submit" title="Anwenden" alt="Anwenden">
		</div>
		<div class="tl_search tl_subpanel">
			<strong><?php echo $lang['calendar_week']; ?>:</strong>
			<input type="text" name="tl_li_week" class="tl_text" value="<?php echo $this->week; ?>">	
		</div>
		<div class="clear"></div>
	</div>
</form>
<div id="tl_buttons">
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['addHoursLabel']; ?>"
		class="add_hours" href="contao/main.php?do=li_timekeeping&amp;table=tl_li_working_hour&amp;act=create"
		style="background-image: url('system/themes/default/images/new.gif');">
		<?php echo $lang['addHours']; ?>
    </a>
     &nbsp; :: &nbsp;
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['manageWorkPackages']; ?>"
		class="manage_work_packages" href="contao/main.php?do=li_timekeeping&amp;table=tl_li_work_package"
		style="background-image: url('system/modules/li_crm/icons/workpackage.png');">
        <?php echo $lang['manageWorkPackages']; ?>
    </a>
</div>
<div id="week_buttons">
	<a href="contao/main.php?do=li_timekeeping&amp;tl_li_week=<?php echo $this->prevWeek; ?>"
	   title="<?php echo $lang['prevWeek']; ?>">
		<img src="system/modules/li_crm/icons/arrow_left.png" alt="<?php echo $lang['prevWeek']; ?>"/>
	</a>
	<a style="float:right;" href="contao/main.php?do=li_timekeeping&amp;tl_li_week=<?php echo $this->nextWeek; ?>"
	   title="<?php echo $lang['nextWeek']; ?>">
		<img src="system/modules/li_crm/icons/arrow_right.png" alt="<?php echo $lang['nextWeek']; ?>"/>
	</a>
</div>
<div id="workin_hours_calendar_wrapper">
	<table id="working_hours_calendar">
		<thead>
			<tr>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][1]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][2]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][3]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][4]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][5]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][6]; ?></td>
				<td><?php echo $GLOBALS['TL_LANG']['DAYS'][0]; ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
<?php for ($day = 0; $day < 7; $day++): ?>
				<td>
	<?php if (!empty($this->hours[$day])): ?>
		<?php foreach ($this->hours[$day] as $entry): ?>
					<div class="working_hour_entry" style="background-color: #<?php echo $entry['customerColor']; ?>">
						<span class="user"><?php echo $entry['user']; ?></span>
						<span class="time"><?php echo $entry['hours'].'h'.(!empty($entry['minutes']) ? ' '.$entry['minutes'].'m ' : ''); ?></span>
						<div class="entry_buttons">
							<a href="contao/main.php?do=li_timekeeping&amp;table=tl_li_work_package&amp;act=edit&amp;id=<?php echo $entry['workPackageId']; ?>"
							   title="<?php echo $lang['editWorkPackage']; ?>">
								<img src="system/modules/li_crm/icons/workpackage_edit.png"
									 alt="<?php echo $lang['editWorkPackage']; ?>" width="16" height="16" />
							</a>
							<a href="contao/main.php?do=li_timekeeping&amp;&table=tl_li_working_hour&amp;act=edit&amp;id=<?php echo $entry['id']; ?>"
							   title="<?php echo $lang['editEntry']; ?>">
								<img src="system/modules/li_crm/icons/edit.png"
									 alt="<?php echo $lang['editEntry']; ?>" width="16" height="16" />
							</a>
							<a href="contao/main.php?do=li_timekeeping&amp;&table=tl_li_working_hour&amp;act=delete&amp;id=<?php echo $entry['id']; ?>"
							   title="<?php echo $lang['deleteEntry']; ?>"
							   onclick="if (!confirm('<?php echo $lang['deleteConfirmDialog']; ?>')) return false; Backend.getScrollOffset();"">
								<img src="system/modules/li_crm/icons/delete.png"
									 alt="<?php echo $lang['deleteEntry']; ?>" width="16" height="16" />
							</a>
						</div>
					</div>
		<?php endforeach; ?>
	<?php endif; ?>
				</td>
<?php endfor; ?>
			</tr>
		</tbody>
	</table>
</div>

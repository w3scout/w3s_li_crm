<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
<meta charset="<?php echo $this->charset; ?>">
<title><?php echo $this->title; ?> - Contao Open Source CMS <?php echo VERSION; ?></title>
<base href="<?php echo $this->base; ?>">
<link rel="stylesheet" href="<?php
  $objCombiner = new Combiner();
  $objCombiner->add('system/themes/'. $this->theme .'/basic.css');
  $objCombiner->add('system/modules/li_crm/css/detailsbox.css');
  echo $objCombiner->getCombinedFile();
?>" media="all">
<!--[if IE]><link rel="stylesheet" href="<?php echo TL_SCRIPT_URL; ?>system/themes/<?php echo $this->theme; ?>/iefixes.css" media="screen"><![endif]-->
</head>
<body class="__ua__">

<div id="container">
<div id="main">

<h1><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['date_legend']; ?></h1>

<h2><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['details']; ?></h2>

<?php echo $this->explanation; ?>
<?php if ($this->appointment != null): ?>
<?php $appointment = $this->appointment; ?>
<table class="tl_details_table">
	<?php if($appointment['customer'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['toCustomer']['0']; ?></td>
		<td><?php echo $appointment['customer']; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['subject']['0']; ?></td>
		<td><?php echo $appointment['subject']; ?></td>
	</tr>
	<?php if($appointment['task'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['task']['0']; ?></td>
		<td><?php echo $appointment['task']; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['startDate']['0']; ?></td>
		<td><?php echo $appointment['startDate']." ".$appointment['startTime']; ?></td>
	</tr>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['endDate']['0']; ?></td>
		<td><?php echo $appointment['endDate']." ".$appointment['endTime']; ?></td>
	</tr>
	<?php if($appointment['repetition'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['repetition']['0']; ?></td>
		<td><?php echo $appointment['repetition']; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['creator']['0']; ?></td>
		<td><?php echo $appointment['creator']; ?></td>
	</tr>
	<?php if($appointment['participants'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['participants']['0']; ?></td>
		<td><?php echo $appointment['participants']; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($appointment['place'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['place']['0']; ?></td>
		<td><?php echo $appointment['place']; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($appointment['note'] != ''): ?>
	<tr>
		<td class="tl_label"><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['note']['0']; ?></td>
		<td><?php echo $appointment['note']; ?></td>
	</tr>
	<?php endif; ?>
</table>
<?php else: ?>
<p><?php echo $GLOBALS['TL_LANG']['tl_li_appointment']['appointmentNotFound']; ?></p>
<?php endif; ?>

</div>
</div>

</body>
</html>
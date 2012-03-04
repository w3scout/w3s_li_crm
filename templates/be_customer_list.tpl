<div id="tl_buttons">
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_member']['new'][1]; ?>" class="header_new customer" href="contao/main.php?do=member&act=create"><?php echo $GLOBALS['TL_LANG']['tl_member']['new'][0]; ?></a> :: <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['new'][1]; ?>" class="header_new project" href="contao/main.php?do=li_customers&table=tl_li_project&act=create"><?php echo $GLOBALS['TL_LANG']['tl_li_project']['new'][0]; ?></a> :: <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['new'][1]; ?>" class="header_new service" href="contao/main.php?do=li_customers&table=tl_li_service&act=create"><?php echo $GLOBALS['TL_LANG']['tl_li_service']['new'][0]; ?></a> :: <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['new'][1]; ?>" class="header_new product" href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=create"><?php echo $GLOBALS['TL_LANG']['tl_li_product']['new'][0]; ?></a>
</div>
<?php if(count($this->customers)) : ?>
    <div id="tl_listing" class="tl_listing_container tree_view">
        <ul class="tl_listing tl_tree">
            <li class="tl_folder_top">
                <div class="tl_left">
                    <img height="16" width="16" alt="" src="system/modules/li_crm/icons/customers.png" /> 
                    <label><?php echo $GLOBALS['TL_LANG']['li_customers']['customers']; ?></label>
                </div>
                <div class="tl_right">&nbsp;</div>
                <div style="clear:both;"></div>
            </li>
            <?php foreach($this->customers as $customer) : ?>
                <li id="customer_<?php echo $customer['customerNumber']; ?>" class="tl_folder customer<?php echo $customer['isDisabled'] ? " disabled" : ""; ?>" onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
                    <div class="tl_left">
						<?php if (count($customer['projects']) > 0 || count($customer['services']) > 0 || count($customer['products']) > 0): ?>
							<a href="contao/main.php?do=li_customers&toggle=customer&id=<?php echo $customer['id']; ?>">
								<?php if ($customer['display']): ?>
									<img src="system/themes/default/images/folMinus.gif" />
								<?php else: ?>
									<img src="system/themes/default/images/folPlus.gif" />
								<?php endif; ?>
							</a>
						<?php else: ?>
							<span style="padding-left: 22px;"></span>
						<?php endif; ?>
                        <?php if(!$customer['isDisabled']): ?>
                            <span><img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['customer_legend']; ?>" src="system/modules/li_crm/icons/customer.png" /></span>
                        <?php else : ?>
                            <span><img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['customer_legend']; ?>" src="system/modules/li_crm/icons/customer_disabled.png" /></span>
                        <?php endif; ?>
                        <strong>
							<?php echo $customer['customerNumber']." ".$customer['customerName']; ?>
						</strong>
                    </div>
                    <div class="tl_right">
                        <a href="contao/main.php?do=member&act=edit&id=<?php echo $customer['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['edit'][1], $customer['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['edit'][0]; ?>" width="12" height="16" /></a>
                        <?php if(!$customer['isDisabled']) : ?>
                            <a href="contao/main.php?do=member&act=copy&id=<?php echo $customer['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['copy'][1], $customer['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['copy'][0]; ?>" width="14" height="16" /></a>
                        <a href="contao/main.php?do=member&act=delete&id=<?php echo $customer['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['delete'][1], $customer['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $customer['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['edit'][0]; ?>" width="14" height="16" /></a>
                        <?php else : ?>
                            <span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['show'][0]; ?>" width="14" height="16" /></span><span><img src="system/themes/default/images/delete_.gif"	alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['delete'][0]; ?>" width="14" height="16" /></span>
                        <?php endif; ?>
                        <a href="contao/main.php?do=member&act=show&id=<?php echo $customer['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['show'][1], $customer['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['show'][0]; ?>" width="14" height="16" /></a>
                        <a href="contao/main.php?do=member&table=tl_li_contact&id=<?php echo $customer['id'] ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['contacts'][1], $customer['id']); ?>"><img height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['contacts'][0]; ?>" src="system/modules/li_crm/icons/contacts.png" /></a>
                        <a href="contao/main.php?do=member&table=tl_address&id=<?php echo $customer['id'] ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_member']['addresses'][1], $customer['id']); ?>"><img height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_member']['addresses'][0]; ?>" src="system/modules/addresses/icons/addressbook.png" /></a>
                    </div>
                    <div style="clear:both;"></div>
                </li>
				<?php if ($customer['display']): ?>
                    <?php foreach($customer['services'] as $service) : ?>
                        <li class="tl_file simpleService" style="" onmouseout="Theme.hoverDiv(this, 0);"
                            onmouseover="Theme.hoverDiv(this, 1);">
                            <div class="tl_left">
                                <span>
                                    <img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['service_legend']; ?>" src="<?php echo $service['icon']; ?>" />
                                </span>
                                <span><?php echo $service['serviceTitle']; ?></span>
                            </div>
                            <div class="tl_right">
                                <?php if(!$customer['isDisabled']) : ?>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_service&act=edit&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['edit'][1], $service['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['edit'][0]; ?>" width="12" height="16" /></a>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_service&act=copy&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['copy'][1], $service['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['copy'][0]; ?>" width="14" height="16" /></a>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_service&act=delete&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['delete'][1], $service['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $service['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['delete'][0]; ?>" width="14" height="16" /></a>
                                <?php else: ?>
                                    <span><img src="system/themes/default/images/edit_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['edit'][0]; ?>" width="12" height="16" /></span>
                                    <span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['copy'][0]; ?>" width="14" height="16" /></span>
                                    <span><img src="system/themes/default/images/delete_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['delete'][0]; ?>" width="14" height="16" /></span>
                                <?php endif; ?>
                                <a href="contao/main.php?do=li_customers&table=tl_li_service&act=show&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['show'][1], $service['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['show'][0]; ?>" width="14" height="16" /></a>
                            </div>
                            <div style="clear:both;"></div>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach($customer['products'] as $product): ?>
                        <li class="tl_file simpleProduct" style="" onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
                            <div class="tl_left">
                                <span><img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['product_legend']; ?>" src="<?php echo $product['icon']; ?>" /></span>
                                <span><?php echo $product['productTitle']; ?></span>
                            </div>
                            <div class="tl_right">
                                <?php if(!$customer['isDisabled']) : ?>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=edit&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['edit'][1], $product['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['edit'][0]; ?>" width="12" height="16" /></a>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=copy&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['copy'][1], $product['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['copy'][0]; ?>" width="14" height="16" /></a>
                                    <a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=delete&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['delete'][1], $product['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $product['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['delete'][0]; ?>" width="14" height="16" /></a>
                                <?php else: ?>
                                    <span><img src="system/themes/default/images/edit_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['edit'][0]; ?>" width="12" height="16" /></span>
                                    <span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['copy'][0]; ?>" width="14" height="16" /></span>
                                    <span><img src="system/themes/default/images/delete_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['delete'][0]; ?>" width="14" height="16" /></span>
                                <?php endif; ?>
                                <a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=show&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['show'][1], $product['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['show'][0]; ?>" width="14" height="16" /></a>
                            </div>
                            <div style="clear:both;"></div>
                        </li>
                    <?php endforeach; ?>
					<?php foreach($customer['projects'] as $project) : ?>
						<li class="tl_file project" style="" onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
							<div class="tl_left">
								<?php if (count($project['services']) > 0 || count($project['products']) > 0): ?>
									<a href="contao/main.php?do=li_customers&toggle=project&id=<?php echo $project['id']; ?>">
										<?php if ($project['display'] && (count($project['services']) > 0 || count($project['products']) > 0)): ?>
											<img src="system/themes/default/images/folMinus.gif" />
										<?php else: ?>
											<img src="system/themes/default/images/folPlus.gif" />
										<?php endif; ?>
									</a>
								<?php else: ?>
									<span style="padding-left: 22px;"></span>
								<?php endif; ?>
								<span><img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['project_legend']; ?>" src="system/modules/li_crm/icons/projects.png" /> </span>
								<em><?php echo $project['projectNumber']; ?> - <?php echo $project['title']; ?></em>
							</div>
							<div class="tl_right">
								<?php if(!$customer['isDisabled']) : ?>
									<a href="contao/main.php?do=li_customers&table=tl_li_project&act=edit&id=<?php echo $project['id']; ?>"	title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_project']['edit'][1], $project['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['edit'][0]; ?>" width="12" height="16" /></a>
									<a href="contao/main.php?do=li_customers&table=tl_li_project&act=copy&id=<?php echo $project['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_project']['copy'][1], $project['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['copy'][0]; ?>" width="14" height="16" /></a>
									<a href="contao/main.php?do=li_customers&table=tl_li_project&act=delete&id=<?php echo $project['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_project']['delete'][1], $project['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $project['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['delete'][0]; ?>" width="14" height="16" /></a>
								<?php else: ?>
									<span><img src="system/themes/default/images/edit_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['edit'][0]; ?>" width="12" height="16" /></span>
									<span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['copy'][0]; ?>" width="14" height="16" /></span>
									<span><img src="system/themes/default/images/delete_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['delete'][0]; ?>" width="14" height="16" /></span>
								<?php endif; ?>
								<a href="contao/main.php?do=li_customers&table=tl_li_project&act=show&id=<?php echo $project['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_project']['show'][1], $project['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_project']['show'][0]; ?>" width="14" height="16" /></a>
							</div>
							<div style="clear:both;"></div>
						</li>
						<?php if ($project['display']): ?>
							<?php foreach($project['services'] as $service) : ?>
								<li class="tl_file service" style="" onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
									<div class="tl_left">
										<span>
											<img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['service_legend']; ?>" src="<?php echo $service['icon']; ?>" />
										</span>
										<span><?php echo $service['serviceTitle']; ?></span>
									</div>
									<div class="tl_right">
										<?php if(!$customer['isDisabled']) : ?>
                                            <a href="contao/main.php?do=li_customers&table=tl_li_service&act=edit&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['edit'][1], $service['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['edit'][0]; ?>" width="12" height="16" /></a>
                                            <a href="contao/main.php?do=li_customers&table=tl_li_service&act=copy&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['copy'][1], $service['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['copy'][0]; ?>" width="14" height="16" /></a>
											<a href="contao/main.php?do=li_customers&table=tl_li_service&act=delete&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['delete'][1], $service['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $service['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['delete'][0]; ?>" width="14" height="16" /></a>
										<?php else: ?>
                                            <span><img src="system/themes/default/images/edit_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['edit'][0]; ?>" width="12" height="16" /></span>
                                            <span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['copy'][0]; ?>" width="14" height="16" /></span>
											<span><img src="system/themes/default/images/delete_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['delete'][0]; ?>" width="14" height="16" /></span>
										<?php endif; ?>
										<a href="contao/main.php?do=li_customers&table=tl_li_service&act=show&id=<?php echo $service['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_service']['show'][1], $service['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_service']['show'][0]; ?>" width="14" height="16" /></a>
									</div>
									<div style="clear:both;"></div>
								</li>
							<?php endforeach; ?>
                            <?php foreach($project['products'] as $product): ?>
								<li class="tl_file product" style="" onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
									<div class="tl_left">
										<span>
											<img class="icon" height="16" width="16" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['product_legend']; ?>" src="<?php echo $product['icon']; ?>" />
										</span>
										<span><?php echo $product['productTitle']; ?></span>
									</div>
									<div class="tl_right">
										<?php if(!$customer['isDisabled']) : ?>
                                            <a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=edit&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['edit'][1], $product['id']); ?>"><img src="system/themes/default/images/edit.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['edit'][0]; ?>" width="12" height="16" /></a>
											<a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=copy&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['copy'][1], $product['id']); ?>"><img src="system/themes/default/images/copy.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['copy'][0]; ?>" width="14" height="16" /></a>
											<a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=delete&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['delete'][1], $product['id']); ?>" onclick="if (!confirm('<?php echo sprintf($GLOBALS['TL_LANG']['MSC']['deleteConfirm'], $product['id']); ?>')) return false; Backend.getScrollOffset();"><img src="system/themes/default/images/delete.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['delete'][0]; ?>" width="14" height="16" /></a>
										<?php else: ?>
											<span><img src="system/themes/default/images/edit_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['edit'][0]; ?>" width="12" height="16" /></span>
											<span><img src="system/themes/default/images/copy_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['copy'][0]; ?>" width="14" height="16" /></span>
											<span><img src="system/themes/default/images/delete_.gif" alt="<?php echo $GLOBALS['TL_LANG']['tl_li_product']['delete'][0]; ?>" width="14" height="16" /></span>
										<?php endif; ?>
										<a href="contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=show&id=<?php echo $product['id']; ?>" title="<?php echo sprintf($GLOBALS['TL_LANG']['tl_li_product']['show'][1], $product['id']); ?>"><img src="system/themes/default/images/show.gif" alt="<?php echo $$GLOBALS['TL_LANG']['tl_li_service']['edit'][0]; ?>" width="14" height="16" /></a>
									</div>
									<div style="clear:both;"></div>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else : ?>
    <p class="tl_empty"><?php echo $GLOBALS['TL_LANG']['li_customers']['noEntries']; ?></p>
<?php endif; ?>